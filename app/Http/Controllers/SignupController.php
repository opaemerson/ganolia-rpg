<?php

namespace App\Http\Controllers;

use App\Enum\ProfileEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\UserRequest;

class SignupController
{
    public function sendCode(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $code = random_int(100000, 999999);

            Cache::put(
                'signup_' . $validated['email'],
                [
                    'login' => $validated['login'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'code' => $code,
                ],
                now()->addMinutes(10)
            );

            Mail::send('mails.mail-confirm-code', [
                'userName' => $validated['login'],
                'code' => $code,
            ], function ($message) use ($validated) {
                $message->to($validated['email'])
                    ->subject('Confirmação de e-mail');
            });


            return response()->json([
                'success' => true,
                'message' => 'Código enviado com sucesso'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required'
        ]);

        $cache = Cache::get('signup_' . $request->email);

        if (!$cache || $cache['code'] != $request->code) {
            return response()->json([
                'error' => 'Código inválido ou expirado'
            ], 422);
        }

        $user = User::create([
            'login' => $cache['login'],
            'email' => $cache['email'],
            'password' => Hash::make($cache['password']),
            'profile_id' => ProfileEnum::USUARIO->id()
        ]);

        Cache::forget('signup_' . $request->email);
        Auth::login($user);

        return response()->json([
            'success' => true,
        ]);
    }
}
