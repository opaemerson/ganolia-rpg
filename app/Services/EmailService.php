<?php
namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Mail\Mailtrap;

class EmailService
{
    public static function sendAccountVerificationEmail(array $userData)
    {
        $token = Str::random(120);
        Cache::put('pending_user_' . $token, $userData, 120);
        $linkValidation = url("/api/verify-email/create-account/{$token}");

        Mail::to($userData['email'])
            ->send(new Mailtrap([
                'view' => 'mails.confirmation',
                'fromEmail' => $userData['email'],
                'subject' => 'Confirmação de e-mail [NOME_PROJETO]',
                'linkValidation' => $linkValidation
            ]));
    }

    public static function sendForgetPasswordEmail(array $userData)
    {
        $token = Str::random(120);
        Cache::put('reset_password_' . $token, $userData, 120);
        $linkValidation = url("/api/verify-email/reset-password/{$token}");

        Mail::to($userData['email'])
            ->send(new Mailtrap([
                'view' => 'mails.forgetPassword',
                'fromEmail' => $userData['email'],
                'subject' => 'Confirmação de redefinição de senha [NOME_PROJETO]',
                'linkValidation' => $linkValidation
            ]));
    }
}
