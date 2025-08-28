<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\TransaksiController;

Route::get('/', [LoginController::class, 'formLogin']);

Route::group(['admin'], function () {

    Route::get('/dashboard', function () {
        return view('content.dashboard');
    })->name('dashboard');
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('layanan', LayananController::class);
    Route::resource('transaksi', TransaksiController::class);
})->middleware('auth');





