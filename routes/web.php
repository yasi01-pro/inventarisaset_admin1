<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokasiAsetController;
use App\Http\Controllers\KategoriAsetController;
use App\Http\Controllers\PemeliharaanAsetController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIC (TANPA LOGIN)
|--------------------------------------------------------------------------
*/

// Halaman login (TAMPILAN)
Route::get('/', [AuthController::class, 'showLogin'])->name('login');

// Proses login (FORM POST)
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE SETELAH LOGIN (CEKNYA DI CONTROLLER, BUKAN MIDDLEWARE)
|--------------------------------------------------------------------------
*/

// Dashboard utama
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Alias khusus untuk sidebar yang pakai admin.dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// User (dicek role di controller)
Route::resource('user', UserController::class);

// Warga & Bina Desa
Route::resource('warga', WargaController::class);

Route::resource('kategori-aset', KategoriAsetController::class);

Route::resource('aset', AsetController::class);

Route::resource('lokasi-aset', LokasiAsetController::class);

Route::resource('pemeliharaan-aset', PemeliharaanAsetController::class);

