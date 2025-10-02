<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // <--- tambahin ini
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
        // Biar $profil bisa dipakai di semua view
        if (Schema::hasTable('profil_perusahaan')) {
            view()->share('profil', ProfilPerusahaan::first());
        } 
        if (Schema::hasTable('layanan')) {
            view()->share('layanans', Layanan:: all());
        }
        if (Schema::hasTable('diskon')) {
            view()->share('diskons', Diskon::where('aktif', 1)->get());
        }

    }
}
