<?php

namespace App\Http\Middleware;

use App\Enum\ProfileEnum;
use App\Models\Functionality;
use App\Models\Module;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnsureUserHasPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Admin bypass (same convention used in PermissionService)
        $isAdmin = isset($user->license_id) && (int) $user->license_id === 99;
        if ($isAdmin) {
            return $next($request);
        }

        if (ProfileEnum::SUPERADMIN->isUser($user)) {
            return $next($request);
        }

        $profileId = $user->profile_id ?? null;

        // Protect module navigation endpoints
        if ($request->routeIs('modules.show')) {
            $slug = (string) $request->route('slug');
            $moduleId = Module::query()
                ->where('slug', $slug)
                ->where('is_active', true)
                ->value('id');

            if (!$moduleId || !$profileId) {
                return redirect()->route('system.index')->with('error', 'Você não tem permissão para acessar este recurso.');
            }

            $allowed = DB::table('profiles_modules')
                ->where('profile_id', $profileId)
                ->where('module_id', $moduleId)
                ->exists();

            if (!$allowed) {
                return redirect()->route('system.index')->with('error', 'Você não tem permissão para acessar este recurso.');
            }
        }

        if ($request->routeIs('modules.functionalities')) {
            $moduleId = (int) $request->route('id');

            if (!$profileId) {
                return redirect()->route('system.index')->with('error', 'Você não tem permissão para acessar este recurso.');
            }

            $allowed = DB::table('profiles_modules')
                ->where('profile_id', $profileId)
                ->where('module_id', $moduleId)
                ->exists();

            if (!$allowed) {
                return redirect()->route('system.index')->with('error', 'Você não tem permissão para acessar este recurso.');
            }
        }

        $path = trim($request->path(), '/');
        $routeName = optional($request->route())->getName();

        $functionality = Functionality::query()
            ->where(function ($q) use ($path, $routeName) {
                if ($path !== '') {
                    $q->where('route', $path)
                        ->orWhereRaw('? LIKE CONCAT(route, \'/%\')', [$path]);
                }

                if ($routeName) {
                    $q->orWhere('route', $routeName)
                        ->orWhereRaw('? LIKE CONCAT(route, \'.%\')', [$routeName]);
                }
            })
            ->orderByRaw('LENGTH(route) DESC')
            ->first();

        if (!$functionality) {
            return $next($request);
        }

        if (!$profileId) {
            return redirect()->route('system.index')->with('error', 'Você não tem permissão para acessar este recurso.');
        }

        $allowed = DB::table('profile_functionalities')
            ->where('profile_id', $profileId)
            ->where('functionality_id', $functionality->id)
            ->exists();

        if (!$allowed) {
            return redirect()->route('system.index')->with('error', 'Você não tem permissão para acessar este recurso.');
        }

        return $next($request);
    }
}
