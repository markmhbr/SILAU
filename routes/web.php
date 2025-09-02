<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Pelanggan\LayananPelangganController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('content.admin.dashboard');
    })->name('dashboard');
    Route::resource('admin/pelanggan', PelangganController::class)->names('admin.pelanggan');
    Route::resource('admin/layanan', LayananController::class)->names('admin.layanan');
    Route::resource('admin/transaksi', TransaksiController::class)->names('admin.transaksi');
    Route::put('/admin/transaksi/{id}/status/{status?}', [TransaksiController::class, 'updateStatus'])->name('admin.transaksi.status');
});
Route::middleware(['auth','role:pelanggan'])->group(function () {
    Route::resource('pelanggan/profil', ProfilPelangganController::class)->names('pelanggan.profil');
    Route::resource('pelanggan/layanan', LayananPelangganController::class)->names('pelanggan.layanan');
});

Route::controller(LoginController::class)->group(function () {
Route::get('/login', 'showLoginForm')->name('login');
Route::post('/login', 'login');
Route::post('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
Route::get('/register', 'showRegistrationForm')->name('register');
Route::post('/register', 'register');
});






