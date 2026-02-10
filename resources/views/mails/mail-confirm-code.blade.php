<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f3e7ff;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .header .logo-flow {
            color: #dbeafe;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .message {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .code-container {
            background: linear-gradient(135deg, #f3e7ff 0%, #dbeafe 100%);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border: 2px solid #667eea;
        }

        .code-label {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .code {
            font-size: 42px;
            font-weight: 700;
            color: #4F46E5;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }

        .expiry {
            font-size: 13px;
            color: #991b1b;
            margin-top: 15px;
            font-weight: 600;
        }

        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
            font-size: 14px;
            color: #92400e;
        }

        .footer {
            background-color: #f9fafb;
            padding: 25px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            border-top: 1px solid #e5e7eb;
        }

        .footer a {
            color: #4F46E5;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Projeto <span class="logo-flow">Teste</span></h1>
        </div>

        <div class="content">
            <div class="greeting">
                Olá, {{ $userName }}!
            </div>

            <div class="message">
                Seu código de verificação foi gerado com sucesso. Use-o para confirmar seu e-mail:
            </div>

            <div class="code-container">
                <div class="code-label">Código de Verificação</div>
                <div class="code">{{ $code }}</div>
                <div class="expiry">⏱ Este código expira em 10 minutos</div>
            </div>

            <div class="message">
                Digite este código na página de confirmação para validar seu cadastro.
            </div>

            <div class="warning">
                <strong>⚠️ Atenção:</strong> Se você não solicitou a verificação, ignore este e-mail.
            </div>
        </div>

        <div class="footer">
            <p>Este é um e-mail automático, por favor não responda.</p>
            <p>&copy; {{ date('Y') }} AgendaFlow. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
