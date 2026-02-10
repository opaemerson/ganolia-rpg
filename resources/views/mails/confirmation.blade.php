<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirme seu e-mail - Agendaflow</title>
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
        }
        h1 {
            color: #1a73e8;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 20px 0;
            background-color: #1a73e8;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo(a) ao Agendaflow!</h1>
        <p>Obrigado por se cadastrar na Agendaflow. Para ativar sua conta, por favor, confirme seu e-mail clicando no botão abaixo:</p>
        <p style="text-align:center;">
            <a href="{{ $linkValidation }}" class="button">Confirmar e-mail</a>
        </p>
        <p>Se você não se cadastrou na Agendaflow, ignore este e-mail.</p>
        <div class="footer">
           Esta confirmação expira em 2 minutos.
        </div>
    </div>
</body>
</html>
