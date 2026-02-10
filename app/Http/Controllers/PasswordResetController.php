<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;

class PasswordResetController
{
    /**
     * Send verification code to user's email
     */
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email inválido.'
            ], 422);
        }

        $email = $request->email;

        // Check if user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email não encontrado em nosso sistema.'
            ], 404);
        }

        // Check rate limiting (prevent spam)
        $rateLimitKey = "password_reset_rate:{$email}";
        if (Cache::has($rateLimitKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Aguarde alguns minutos antes de solicitar um novo código.'
            ], 429);
        }

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in cache for 15 minutes
        $cacheKey = "password_reset:{$email}";
        Cache::put($cacheKey, [
            'code' => $code,
            'attempts' => 0,
            'created_at' => now()->timestamp
        ], now()->addMinutes(15));

        // Set rate limit (1 minute)
        Cache::put($rateLimitKey, true, now()->addMinutes(1));

        // Send email
        try {
            Mail::to($email)->send(new ResetPasswordMail($code, $user->name ?? 'Usuário'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar email. Tente novamente.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Código de verificação enviado para seu email.',
            'expires_in' => 900 // 15 minutes in seconds
        ]);
    }

    /**
     * Verify the code entered by user
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos.'
            ], 422);
        }

        $email = $request->email;
        $code = $request->code;
        $cacheKey = "password_reset:{$email}";

        // Check if code exists in cache
        $resetData = Cache::get($cacheKey);
        if (!$resetData) {
            return response()->json([
                'success' => false,
                'message' => 'Código expirado ou inválido. Solicite um novo código.'
            ], 404);
        }

        // Check attempts (max 5)
        if ($resetData['attempts'] >= 5) {
            Cache::forget($cacheKey);
            return response()->json([
                'success' => false,
                'message' => 'Muitas tentativas incorretas. Solicite um novo código.'
            ], 429);
        }

        // Verify code
        if ($resetData['code'] !== $code) {
            $resetData['attempts']++;
            Cache::put($cacheKey, $resetData, now()->addMinutes(15));

            return response()->json([
                'success' => false,
                'message' => 'Código incorreto. Tentativas restantes: ' . (5 - $resetData['attempts'])
            ], 401);
        }

        // Code is valid, generate reset token
        $resetToken = bin2hex(random_bytes(32));
        $tokenKey = "password_reset_token:{$resetToken}";

        Cache::put($tokenKey, [
            'email' => $email,
            'verified' => true
        ], now()->addMinutes(10)); // Token valid for 10 minutes

        return response()->json([
            'success' => true,
            'message' => 'Código verificado com sucesso.',
            'reset_token' => $resetToken
        ]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_token' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos.',
                'errors' => $validator->errors()
            ], 422);
        }

        $resetToken = $request->reset_token;
        $tokenKey = "password_reset_token:{$resetToken}";

        // Check if token exists
        $tokenData = Cache::get($tokenKey);
        if (!$tokenData || !$tokenData['verified']) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido ou expirado. Reinicie o processo.'
            ], 404);
        }

        $email = $tokenData['email'];

        // Find user and update password
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado.'
            ], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Clear all cache entries
        Cache::forget($tokenKey);
        Cache::forget("password_reset:{$email}");

        return response()->json([
            'success' => true,
            'message' => 'Senha redefinida com sucesso! Você já pode fazer login.'
        ]);
    }
}
