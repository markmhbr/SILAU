<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // <--- tambahin ini
use App\Models\ProfilPerusahaan;

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
    }
}
