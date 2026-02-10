# Matriz ERP

Projeto Laravel rodando com Sail (Docker), MySQL e Redis, com Vite + Tailwind CSS e Alpine.js.

## Requisitos

- Docker Engine
- Docker Compose (plugin `docker compose`)

Não é necessário ter PHP ou Composer instalados na máquina.

## Onboarding (um comando)

Na raiz do projeto:

```bash
chmod +x ./init.sh
```

```bash
./init.sh
```

## Onboarding (dev / HMR)

Se você quer iniciar o projeto e já deixar o Tailwind/Alpine compilando em tempo real (Vite em watch):

```bash
./init.sh --dev
```

Isso mantém o Vite rodando em foreground. Para parar, use `Ctrl+C` (os containers continuam no ar).

O script:

- copia `.env.example` para `.env` (se ainda não existir)
- instala dependências (Composer e NPM) dentro do container
- sobe a stack com Sail (PHP 8.4, MySQL 8.4, Redis)
- ajusta permissões de `storage/` e `bootstrap/cache/`
- roda `php artisan migrate --seed`

Após isso, acesse:

- App: http://localhost:81 (ou o `APP_PORT` do seu `.env`)
- Vite: http://localhost:5173

## Comandos do dia a dia

- Subir containers: `./vendor/bin/sail up -d`
- Parar containers: `./vendor/bin/sail stop`
- Logs: `./vendor/bin/sail logs -f`
- Artisan: `./vendor/bin/sail artisan <comando>`
- NPM/Vite (dev): `./vendor/bin/sail npm run dev`
- Testes: `./vendor/bin/sail test`

## Rebuild (quando mudar Docker)

```bash
./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d
```
