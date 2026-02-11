<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\ModuleController as SuperadminModuleController;
use App\Http\Controllers\Superadmin\FunctionalityController as SuperadminFunctionalityController;


Route::view('/ui-test', 'ui-test');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/signup', [AuthController::class, 'signUp'])->name('signup');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name("forgot-password");

//ROUTE - LOGIN/LOGOUT & SIGNUP
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/signup/send-code', [SignupController::class, 'sendCode']);
Route::post('/signup/verify-code', [SignupController::class, 'verifyCode']);

//ROUTE - AUTH
Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [AuthController::class, 'redirect'])->name('auth.redirect');
    Route::get('{provider}/callback', [AuthController::class, 'callback'])->name('auth.callback');
});

Route::post('/forgot-password/send-code', [PasswordResetController::class, 'sendCode'])->name('password.send-code');
Route::post('/forgot-password/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify-code');
Route::post('/forgot-password/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

Route::middleware(['auth.user', 'superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/', [SuperadminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('modules', SuperadminModuleController::class)->except(['show']);
        Route::resource('functionalities', SuperadminFunctionalityController::class)->except(['show']);
    });

//ROUTE - USERS
Route::middleware(['auth.user', 'permission'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('system.index');
    });

    Route::get('/system', [SystemController::class, 'index'])->name('system.index');

    Route::prefix('system')->group(function () {
        Route::prefix('permissions')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/profiles', [PermissionController::class, 'profiles'])->name('permissions.profiles');
            Route::get('/profiles/{profile}', [PermissionController::class, 'show'])->name('permissions.show');
            Route::put('/profiles/{profile}', [PermissionController::class, 'update'])->name('permissions.update');
        });

        Route::resource('profiles', ProfileController::class)->except(['show']);
    });

    Route::prefix('register')->group(function () {

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});