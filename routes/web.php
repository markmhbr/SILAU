<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\PelangganController;

Route::get('/', [LoginController::class, 'formLogin']);

Route::group(['admin'], function () {

    Route::get('/dashboard', function () {
        return view('content.dashboard');
    })->name('dashboard');
    Route::resource('pelanggan', PelangganController::class);
})->middleware('auth');





