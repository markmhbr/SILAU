<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        view()->share('profil', ProfilPerusahaan::first());
    }
}
