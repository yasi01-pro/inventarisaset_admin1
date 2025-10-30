<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\BinaDesaController;
use App\Http\Middleware\SessionAuth;
use App\Http\Middleware\AdminMiddleware;

Route::middleware([SessionAuth::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('user', UserController::class);
    });

    Route::resource('warga', WargaController::class);
    Route::resource('bina-desa', BinaDesaController::class);
});

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['session.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['admin'])->group(function () {
        Route::resource('user', UserController::class);
    });

    Route::resource('warga', WargaController::class);
    Route::resource('bina-desa', BinaDesaController::class);
});
