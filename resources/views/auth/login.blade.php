<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PROJETO_NOME - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>

</head>

<body>
    @include('alerts')

    <div class="login-card">
        <div class="logo-container">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="AgendaFlow Logo" class="logo-img"> --}}
            <h1 class="logo-text">Projeto<span class="logo-flow">Exemplo</span></h1>
        </div>

        <div class="text-center mb-4">
            <h2 class="h5 fw-semibold text-dark mb-2">Bem-vindo de volta</h2>
            <p class="text-muted">Faça seu login</p>
        </div>


        <form action="{{ route('login.perform') }}" method="POST" id="loginForm">
            @csrf

            <div class="form-control-icon mb-3">
                <svg class="icon-left" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" width="24" height="24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M12 12a5 5 0 100-10 5 5 0 000 10z" />
                </svg>
                <input type="text" class="form-control" id="login" name="login" placeholder="E-mail ou login" required>
            </div>

            <div class="form-control-icon mb-3">
                <svg class="icon-left" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                <svg class="icon-right" id="togglePassword" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>

            <button type="submit" class="btn btn-primary btn-primary-custom w-100 mb-3">
                Entrar
            </button>

            <div class="text-center mb-3">
                <a href="{{ route("forgot-password") }}">
                    <button type="button" class="btn btn-ghost btn-sm" id="forgotPassword">
                        Esqueci minha senha
                    </button>
                </a>
            </div>

            <div class="divider text-center">
                <span>ou</span>
            </div>

            <div class="d-flex justify-content-center gap-3 mb-4">
                <button type="button" class="social-btn" id="googleLogin" aria-label="Entrar com Google">
                    <svg class="social-icon" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                </button>
                <button type="button" class="social-btn" id="facebookLogin" aria-label="Entrar com Facebook">
                    <svg class="social-icon" viewBox="0 0 24 24">
                        <path fill="#1877F2"
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        <path fill="#FFFFFF"
                            d="M16.67 15.543l.532-3.47h-3.328v-2.25c0-.949.465-1.874 1.956-1.874h1.513V5.996s-1.374-.235-2.686-.235c-2.741 0-4.533 1.662-4.533 4.669v2.642H7.078v3.47h3.047v8.385a12.118 12.118 0 003.75 0v-8.385h2.796z" />
                    </svg>
                </button>
            </div>
            <div class="text-center">
                <span class="text-muted small">
                    Não tem conta?
                    <a href="{{ route('signup') }}" class="text-primary text-decoration-none fw-medium">
                        Cadastre-se
                    </a>
                </span>
            </div>
        </form>
    </div>
</body>

</html>