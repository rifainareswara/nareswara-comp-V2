<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //  Metode ini digunakan untuk mendaftarkan layanan ke dalam container Laravel.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Metode ini dijalankan saat aplikasi di-boot.
        // Digunakan untuk mengatur logic yang dijalankan ketika aplikasi aktif.
        Gate::before(function ($user, $ability) {
            // Mengecek apakah user memiliki role 'super_admin'.
            if ($user->hasRole('super_admin')) {
                // Jika iya, maka akses diberikan tanpa memeriksa izin lebih lanjut.
                return true;
            }
        });
    }
    // Dengan kode di atas, pengguna dengan peran 'super_admin' memiliki akses penuh
    // ke seluruh fitur aplikasi tanpa memeriksa kemampuan spesifik.
}
