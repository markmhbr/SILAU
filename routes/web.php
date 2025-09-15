<?php

use Illuminate\Support\Facades\Route;

// Controllers Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfilPerusahaanController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\DiskonController;
use App\Http\Controllers\Admin\LaporanController;

// Controllers Pelanggan
use App\Http\Controllers\Pelanggan\LayananPelangganController;
use App\Http\Controllers\Pelanggan\ProfilPelangganController;

// Controllers Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Controllers Interface
use App\Http\Controllers\InterfaceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Web Routes untuk bagian interface
|--------------------------------------------------------------------------
*/

Route::get('/', [InterfaceController::class, 'beranda'])->name('beranda');
Route::get('/profil', [InterfaceController::class, 'profil'])->name('profil');
Route::get('/kontak', [InterfaceController::class, 'kontak'])->name('kontak');
Route::get('/testimonial-form', [InterfaceController::class, 'testimonial_form'])->name('testimonial-form');


/*
|--------------------------------------------------------------------------
| Web Routes untuk bagian role admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->name('dashboard');
    Route::resource('/profil-perusahaan', ProfilPerusahaanController::class)->names('profil-perusahaan');
    Route::resource('/pelanggan', PelangganController::class)->names('pelanggan');
    Route::resource('/layanan', LayananController::class)->names('layanan');
    Route::resource('/transaksi', TransaksiController::class)->names('transaksi');
    Route::put('/transaksi/{id}/status/{status?}', [TransaksiController::class, 'updateStatus'])->name('transaksi.status');
    Route::resource('/diskon', DiskonController::class)->names('diskon');
    Route::patch('/diskon/{id}/toggle', [DiskonController::class, 'toggleStatus'])->name('diskon.toggle');
    Route::resource('/laporan', LaporanController::class)->names('laporan');
    Route::get('/struk/{id}', [TransaksiController::class, 'cetakStruk']);
});


/*
|--------------------------------------------------------------------------
| Web Routes untuk bagian role pelanggan
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::resource('/profil', ProfilPelangganController::class)->names('profil');
    Route::resource('/layanan', LayananPelangganController::class)->names('layanan');
    Route::get('/layanan/{id}/detail', [LayananPelangganController::class, 'detail'])->name('layanan.detail');
    Route::post('/layanan/{id}/bayar', [LayananPelangganController::class, 'bayar'])->name('layanan.bayar');
});


/*
|--------------------------------------------------------------------------
| Web Routes untuk bagian Login Dan Logout
|--------------------------------------------------------------------------
*/

Route::controller(LoginController::class)->group(function () {
Route::get('/login', 'showLoginForm')->name('login');
Route::post('/login', 'login');
Route::post('/logout', 'logout')->name('logout');
});


/*
|--------------------------------------------------------------------------
| Web Routes untuk bagian Register
|--------------------------------------------------------------------------
*/

Route::controller(RegisterController::class)->group(function () {
Route::get('/register', 'showRegistrationForm')->name('register');
Route::post('/register', 'register');
});






