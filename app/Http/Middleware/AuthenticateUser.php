<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (request()->routeIs('login') || request()->routeIs('signup')) {
            return redirect()->route('system.index');
        }

        return $next($request);
    }
}
