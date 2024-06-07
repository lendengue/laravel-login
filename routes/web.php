<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login-index');
    Route::post('/', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
});
