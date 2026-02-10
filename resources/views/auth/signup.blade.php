<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - PROJETO EXEMPLO</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Alpine + Tailwind (usado só no modal) -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.0/dist/tailwind.min.css" rel="stylesheet">

    <!-- assets -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body x-data="signup()">

    <div class="signup-card">
        <div x-show="errorMessage" x-transition class="alert alert-error mb-3">
            <div class="alert-content">
                <span x-text="errorMessage"></span>
            </div>
            <span class="close-btn" @click="errorMessage = ''">&times;</span>
        </div>

        <div class="text-center mb-4">
            <h1 class="logo-text">PROJETO<span class="logo-highlight">EXEMPLO</span></h1>
        </div>

        <div class="text-center mb-4">
            <h2 class="h5 fw-semibold text-dark mb-2">Crie sua conta</h2>
            <p class="text-muted">Etapa 1 - Validação de e-mail</p>
        </div>

        @include('alerts')

        <form id="signupForm">
            @csrf

            <div class="mb-3">
                <input type="text" id="login" name="login" class="form-control form-control-custom"
                    placeholder="Login (Usuário)" required>
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control form-control-custom" placeholder="E-mail" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control form-control-custom" placeholder="Senha"
                    required>
            </div>

            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control form-control-custom"
                    placeholder="Confirmar senha" required>
            </div>

            <button type="button" @click="sendCode" class="btn btn-primary-custom w-100">
                Criar Conta
            </button>
        </form>

        <div class="text-center mt-4">
            <span class="text-muted">
                Já tem conta?
                <a href="{{ route('login') }}" class="text-link">Faça login</a>
            </span>
        </div>
    </div>

    <div class="modal-overlay" x-show="showModal" x-transition>
        <div class="modal-card">

            <div class="modal-header">
                <h3>Verificação de e-mail</h3>
                <p>Enviamos um código de 6 dígitos para seu e-mail</p>
            </div>

            <div class="modal-body">
                <p class="mb-3">
                    Digite o código abaixo para confirmar sua identidade:
                </p>

                <div class="input-wrapper mb-4">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zM19 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
                    </svg>

                    <input type="text" x-model="code" maxlength="6"
                        class="form-control-custom text-center modal-code-input" placeholder="000000">
                </div>

                <p class="modal-expiry text-center">
                    ⏱ Este código expira em 15 minutos
                </p>
            </div>

            <div class="modal-footer">
                <button class="btn-primary-custom" @click="verifyCode">
                    Confirmar código
                </button>

                <button class="modal-cancel" @click="showModal = false">
                    Cancelar
                </button>
            </div>
        </div>
    </div>



    <script>
        function signup() {
            return {
                showModal: false,
                code: '',
                email: '',
                errorMessage: '',

                sendCode() {
                    const form = document.getElementById('signupForm');
                    const data = new FormData(form);
                    this.email = data.get('email');
                    console.log(data);

                    fetch('/signup/send-code', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: data
                    })
                        .then(async res => {
                            let json;
                            const contentType = res.headers.get('content-type') || '';

                            if (contentType.includes('application/json')) {
                                json = await res.json();
                            } else {
                                const text = await res.text();
                                throw { errors: { server: [text] } };
                            }

                            if (!res.ok) throw json;
                            return json;
                        })
                        .then(res => {
                            this.showModal = true;
                            this.errorMessage = '';
                        })
                        .catch(err => {
                            if (err.errors) {
                                this.errorMessage = Object.values(err.errors)[0][0];
                            } else if (err.message) {
                                this.errorMessage = err.message;
                            } else {
                                this.errorMessage = 'Erro inesperado. Tente novamente.';
                            }

                        });
                },

                verifyCode() {
                    this.errorMessage = '';

                    fetch('/signup/verify-code', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email: this.email,
                            code: this.code
                        })
                    })
                        .then(async res => {
                            const json = await res.json();
                            if (!res.ok) throw json;
                            return json;
                        })
                        .then(res => {
                            window.location.href = '/';
                        })
                        .catch(err => {
                            this.errorMessage = err.error ?? 'Código inválido';
                        });
                }
            }
        }

    </script>

</body>

</html>