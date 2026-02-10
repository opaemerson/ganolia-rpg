<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgendaFlow - Recuperar Senha</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/forgot-password.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="forgot-password-card">
        <!-- Logo -->
        <div class="logo-container">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="SUA LOGO AQUI" class="logo-img"> --}}
            <h1 class="logo-text">SEU PROJETO<span class="logo-flow"> AQUI</span></h1>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active" data-step="1">
                <div class="step-circle">
                    <svg class="step-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                    <svg class="step-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="step-label">Email</div>
            </div>
            <div class="step-line"></div>
            <div class="step" data-step="2">
                <div class="step-circle">
                    <svg class="step-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <svg class="step-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="step-label">Código</div>
            </div>
            <div class="step-line"></div>
            <div class="step" data-step="3">
                <div class="step-circle">
                    <svg class="step-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <svg class="step-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="step-label">Nova Senha</div>
            </div>
        </div>

        <!-- Alert Messages -->
        <div class="alert-message success-message" id="successMessage">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span id="successText"></span>
        </div>

        <div class="alert-message error-message" id="errorMessage">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="errorText"></span>
        </div>

        <!-- Step 1: Email -->
        <div class="step-content active" id="step1">
            <div class="step-header">
                <h2>Esqueceu sua senha?</h2>
                <p>Digite seu e-mail para receber o código de verificação</p>
            </div>

            <form id="emailForm">
                <div class="form-control-icon">
                    <svg class="icon-left" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                    <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
                </div>

                <div class="info-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Enviaremos um código de 6 dígitos para seu e-mail. O código expira em 15 minutos.</span>
                </div>

                <button type="submit" class="btn btn-primary-custom">
                    <span class="btn-text">Enviar código</span>
                    <span class="btn-spinner"></span>
                </button>
            </form>
        </div>

        <!-- Step 2: Code Verification -->
        <div class="step-content" id="step2">
            <div class="step-header">
                <h2>Digite o código</h2>
                <p>Enviamos um código de 6 dígitos para <strong id="emailDisplay"></strong></p>
            </div>

            <form id="codeForm">
                <div class="code-inputs">
                    <input type="text" maxlength="1" class="code-input" data-index="0" pattern="[0-9]"
                        inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="1" pattern="[0-9]"
                        inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="2" pattern="[0-9]"
                        inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="3" pattern="[0-9]"
                        inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="4" pattern="[0-9]"
                        inputmode="numeric">
                    <input type="text" maxlength="1" class="code-input" data-index="5" pattern="[0-9]"
                        inputmode="numeric">
                </div>

                <div class="timer-box" id="timerBox">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Código expira em: <strong id="timer">15:00</strong></span>
                </div>

                <button type="submit" class="btn btn-primary-custom">
                    <span class="btn-text">Verificar código</span>
                    <span class="btn-spinner"></span>
                </button>

                <button type="button" class="btn btn-secondary-custom" id="resendCode">
                    Reenviar código
                </button>
            </form>
        </div>

        <!-- Step 3: New Password -->
        <div class="step-content" id="step3">
            <div class="step-header">
                <h2>Nova senha</h2>
                <p>Escolha uma senha forte para sua conta</p>
            </div>

            <form id="passwordForm">
                <div class="form-control-icon">
                    <svg class="icon-left" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input type="password" id="password" name="password" placeholder="Nova senha" required
                        minlength="8">
                    <button type="button" class="toggle-password" data-target="password">
                        <svg class="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>

                <div class="password-strength" id="passwordStrength">
                    <div class="strength-bar">
                        <div class="strength-fill"></div>
                    </div>
                    <div class="strength-text">Força da senha: <span></span></div>
                </div>

                <div class="form-control-icon">
                    <svg class="icon-left" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirme a nova senha" required minlength="8">
                    <button type="button" class="toggle-password" data-target="password_confirmation">
                        <svg class="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>

                <div class="info-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>A senha deve ter no mínimo 8 caracteres.</span>
                </div>

                <button type="submit" class="btn btn-primary-custom">
                    <span class="btn-text">Redefinir senha</span>
                    <span class="btn-spinner"></span>
                </button>
            </form>
        </div>

        <!-- Back to Login -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para o login
            </a>
        </div>
    </div>

    <script src="{{ asset('js/forgot-password.js') }}"></script>
</body>

</html>