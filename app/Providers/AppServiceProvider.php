<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Enum\ProfileEnum;
use App\Models\Module;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::share('user', Auth::user());

        View::composer('*', function ($view) {

            $user = Auth::user();

            $viewName = method_exists($view, 'getName') ? (string) $view->getName() : '';
            if ($viewName !== '' && str_starts_with($viewName, 'superadmin.')) {
                return;
            }

            $activeModuleSlug = request()->segment(1) === 'modules'
                ? request()->segment(2)
                : request()->segment(1);

            if (!$user) {
                $view->with('user', null);
                $view->with('modules', collect());
                $view->with('activeModuleSlug', $activeModuleSlug);
                return;
            }

            $profileId = $user?->profile_id;
            $isSuperadmin = ProfileEnum::SUPERADMIN->isUser($user);

            $modules = Module::query()
                ->where('is_active', true)
                ->when(!$isSuperadmin && $profileId, function ($query) use ($profileId) {
                    $query->whereIn('id', function ($sub) use ($profileId) {
                        $sub->select('module_id')
                            ->from('profiles_modules')
                            ->where('profile_id', $profileId);
                    });
                })
                ->orderBy('order')
                ->with([
                    'functionalities' => function ($q) use ($profileId, $isSuperadmin) {
                        if ($isSuperadmin) {
                            $q->orderBy('order');
                            return;
                        }

                        if ($profileId) {
                            $q->whereIn('id', function ($sub) use ($profileId) {
                                $sub->select('functionality_id')
                                    ->from('profile_functionalities')
                                    ->where('profile_id', $profileId);
                            })->orderBy('order');
                        } else {
                            $q->whereRaw('0 = 1');
                        }
                    }
                ])
                ->get();

            $view->with(compact('modules', 'user'));
            $view->with('activeModuleSlug', $activeModuleSlug);
        });
    }
}
