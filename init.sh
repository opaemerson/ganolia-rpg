#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "${BASH_SOURCE[0]}")"

bold="\033[1m"
green="\033[32m"
yellow="\033[33m"
red="\033[31m"
reset="\033[0m"

log() { echo -e "${green}${bold}==>${reset} $*"; }
warn() { echo -e "${yellow}${bold}==>${reset} $*"; }
err() { echo -e "${red}${bold}==>${reset} $*" 1>&2; }

die() { err "$*"; exit 1; }

usage() {
  cat <<'EOF'
Uso:
  ./init.sh [--dev]

Opções:
  --dev   Sobe tudo e mantém o Vite rodando (HMR) em foreground.
  -h, --help  Mostra esta ajuda.
EOF
}

DEV_MODE=0
for arg in "$@"; do
  case "$arg" in
    --dev)
      DEV_MODE=1
      ;;
    -h|--help)
      usage
      exit 0
      ;;
    *)
      die "Argumento desconhecido: ${arg} (use --help)"
      ;;
  esac
done

require_cmd() {
  command -v "$1" >/dev/null 2>&1 || die "Comando obrigatório não encontrado: $1"
}

require_cmd docker

if docker compose version >/dev/null 2>&1; then
  DOCKER_COMPOSE=(docker compose)
else
  require_cmd docker-compose
  DOCKER_COMPOSE=(docker-compose)
fi

# Verifica Docker rodando
if ! docker info >/dev/null 2>&1; then
  die "Docker não está rodando. Inicie o Docker e tente novamente."
fi

# Cria .env se necessário
if [ ! -f ./.env ]; then
  if [ ! -f ./.env.example ]; then
    die "Arquivo .env.example não encontrado."
  fi
  log "Criando .env a partir de .env.example"
  cp ./.env.example ./.env
fi

# Garante WWWUSER/WWWGROUP para evitar permissões ruins no Linux
ensure_env_kv() {
  local key="$1"
  local value="$2"

  if grep -qE "^${key}=" ./.env; then
    return 0
  fi

  echo "${key}=${value}" >> ./.env
}

ensure_env_kv "WWWUSER" "$(id -u)"
ensure_env_kv "WWWGROUP" "$(id -g)"

# Carrega variáveis (melhor esforço)
set -a
# shellcheck source=/dev/null
source ./.env || true
set +a

SAIL="./vendor/bin/sail"

# Se ainda não existe o Sail (vendor não instalado), instala via Composer dentro de container
if [ ! -x "$SAIL" ]; then
  warn "Sail não encontrado em ./vendor/bin/sail. Rodando composer install via container (sem PHP/Composer local)."

  docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$PWD:/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --no-interaction --prefer-dist
fi

if [ ! -x "$SAIL" ]; then
  die "Não foi possível localizar ./vendor/bin/sail após o composer install."
fi

# Pastas essenciais e permissões
log "Ajustando permissões (storage/ e bootstrap/cache/)"
mkdir -p storage/framework/{cache,data,sessions,testing,views} bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache || true

# Sobe containers
log "Subindo containers com Sail (build se necessário)"
"$SAIL" up -d --build

# Espera MySQL ficar pronto
log "Aguardando MySQL ficar pronto"
DB_PASSWORD="${DB_PASSWORD:-password}"
for i in {1..60}; do
  if "${DOCKER_COMPOSE[@]}" exec -T mysql mysqladmin ping -p"$DB_PASSWORD" --silent >/dev/null 2>&1; then
    break
  fi
  sleep 2
  if [ "$i" -eq 60 ]; then
    die "MySQL não ficou pronto a tempo. Verifique logs: ./vendor/bin/sail logs -f mysql"
  fi
done

# Gera APP_KEY se vazio
if grep -qE '^APP_KEY\s*=\s*$' ./.env; then
  log "Gerando APP_KEY"
  "$SAIL" artisan key:generate
fi

# Instala deps PHP (caso ainda não tenha)
log "Instalando dependências PHP (composer install)"
"$SAIL" composer install --no-interaction --prefer-dist

# Instala deps JS (incluindo Alpine)
log "Instalando dependências JS (npm install)"
"$SAIL" npm install

# Migrate + seed
log "Rodando migrations e seed"
"$SAIL" artisan migrate --seed --force

if [ "$DEV_MODE" -eq 1 ]; then
  VITE_PORT="${VITE_PORT:-5173}"
  log "Tudo pronto (dev mode)!"
  log "App: ${APP_URL:-http://localhost}:${APP_PORT:-80}"
  log "Vite (HMR): http://localhost:${VITE_PORT}"
  warn "Mantendo Vite rodando (Ctrl+C para parar o watcher; containers continuam rodando)."
  exec "$SAIL" npm run dev -- --host 0.0.0.0 --port "$VITE_PORT"
fi

# Build assets (para servir via manifest quando não estiver em --dev)
log "Build de assets (vite build)"
"$SAIL" npm run build

log "Tudo pronto!"
log "App: ${APP_URL:-http://localhost}:${APP_PORT:-80}"
log "Para dev com HMR: ./init.sh --dev (ou ./vendor/bin/sail npm run dev)"
