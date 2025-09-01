<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Auth\LoginController;

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('content.dashboard');
    })->name('dashboard');
    Route::resource('admin/pelanggan', PelangganController::class);
    Route::resource('admin/layanan', LayananController::class);
    Route::resource('admin/transaksi', TransaksiController::class);
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');






