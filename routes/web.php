<?php

use App\Http\Controllers\CalendarEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
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

        Route::prefix('clients')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('clients.index');
            Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
            Route::post('/', [ClientController::class, 'store'])->name('clients.store');
            Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
            Route::put('/{client}', [ClientController::class, 'update'])->name('clients.update');
            Route::delete('/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });

        Route::prefix('suppliers')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('suppliers.index');
            Route::get('/create', [SupplierController::class, 'create'])->name('suppliers.create');
            Route::post('/', [SupplierController::class, 'store'])->name('suppliers.store');
            Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
            Route::put('/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
            Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
        });
    });

    Route::prefix('calendar')->group(function () {
        Route::get('/', [CalendarEventController::class, 'view'])->name('calendar.index');
        Route::get('/events', [CalendarEventController::class, 'index']);
        Route::post('/events', [CalendarEventController::class, 'store']);
        Route::put('/events/{calendarEvent}', [CalendarEventController::class, 'update']);
        Route::delete('/events/{calendarEvent}', [CalendarEventController::class, 'destroy']);
    });

    Route::prefix('stock')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('stock.index');
        Route::get('/product/{productId}', [StockController::class, 'show'])->name('stock.show');
    });

    Route::prefix('purchases')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('/', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
        Route::get('/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
        Route::put('/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
        Route::delete('/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

        Route::post('/{purchase}/confirm', [PurchaseController::class, 'confirm'])->name('purchases.confirm');
        Route::post('/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
    });

    Route::prefix('sales')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('sales.index');
        Route::get('/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::get('/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
        Route::put('/{sale}', [SaleController::class, 'update'])->name('sales.update');
        Route::delete('/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');

        Route::post('/{sale}/confirm', [SaleController::class, 'confirm'])->name('sales.confirm');
        Route::post('/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');
    });

});