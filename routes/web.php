<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('content.dashboard');
});

Route::get('/pelanggan', function () {
    return view('content.Pelanggan');
})->name('pelanggan');



Route::get('/login', [LoginController::class, 'formLogin']);


