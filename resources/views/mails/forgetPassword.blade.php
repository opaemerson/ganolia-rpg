<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinição de Senha - Agendaflow</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #1a73e8;
            font-size: 22px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .code {
            display: inline-block;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 3px;
            background: #f1f3f4;
            padding: 12px 24px;
            border-radius: 5px;
            margin: 20px 0;
            color: #1a73e8;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Redefinição de senha</h1>
        <p>Olá, recebemos uma solicitação para redefinir a senha da sua conta no Agendaflow.</p>
        <p style="text-align:center;">
            <a href="{{ $linkValidation }}" class="button">Confirmar alteração de senha</a>
        </p>
        <p>Se você não solicitou a redefinição de senha, ignore este e-mail.</p>
        <div class="footer">
            Esta confirmação expira em 2 minutos.
        </div>
    </div>
</body>
</html>
