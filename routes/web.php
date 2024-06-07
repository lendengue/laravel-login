<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login-index');
});

Route::middleware('guest')
    ->prefix('login')
    ->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::get('/', 'showLoginForm')->name('login-index');
            Route::post('/', 'login')->name('login');
        });
    });

Route::middleware('auth')
    ->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::prefix('home')->group(function () {
                Route::get('/', 'index')->name('home');
            });
        });
        Route::controller(LoginController::class)->prefix('login')->group(function () {
            Route::post('/logout', 'logout')->name('logout');
        });
    });
    
    Route::controller(LoginController::class)->group(function () {
        Route::get('/teste', 'teste')->name('home');
    });