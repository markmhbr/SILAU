<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\ProfilPerusahaan;
use App\Models\Layanan;
use App\Models\Diskon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Cek koneksi database terlebih dahulu agar tidak crash saat migrasi awal
            DB::connection()->getPdo();

            // Cek ketersediaan tabel sebelum query
            if (Schema::hasTable('profil_perusahaan')) {
                View::share('profil', ProfilPerusahaan::first());
            } 
            
            if (Schema::hasTable('layanan')) {
                View::share('layanans', Layanan::all());
            }
            
            if (Schema::hasTable('diskon')) {
                View::share('diskons', Diskon::where('aktif', 1)->get());
            }

        } catch (\Exception $e) {
            // Jika database belum ada atau tabel belum ada, diamkan saja (silent fail)
            // Agar proses composer install / php artisan migrate tetap bisa jalan
        }

    }
}
