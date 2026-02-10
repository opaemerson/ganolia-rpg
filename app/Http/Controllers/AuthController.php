<?php

namespace App\Http\Controllers;

use App\Enum\ProfileEnum;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('system.index');
        }

        return view('auth.login');
    }

    public function signUp()
    {
        if (Auth::check()) {
            return redirect()->route('system.index');
        }

        return view('auth.signup');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $name = $socialUser->getName() ?? '';
            $email = $socialUser->getEmail();

            $firstName = explode(' ', trim($name))[0] ?: 'user';
            $baseLogin = strtolower($firstName);
            $login = $baseLogin;

            while (User::where('login', $login)->exists()) {
                $login = $baseLogin . rand(100, 9999);
            }

            $user = User::create([
                'email' => $email,
                'login' => $login,
                'password' => Hash::make(Str::random(32)),
                'profile_id' => ProfileEnum::USUARIO->id(),
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/system');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $input = $request->input('login');

        $user = User::where('email', $input)
            ->orWhere('login', $input)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Credenciais inválidas');
        }

        Auth::login($user);

        return redirect()->route('system.index');
    }
}
