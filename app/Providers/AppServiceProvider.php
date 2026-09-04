<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        } elseif (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'ngrok')) {
            URL::forceScheme('https');
        }

        // Set timezone ke WIB agar semua Carbon/datetime konsisten dengan data di database
        // Data di DB tersimpan dalam WIB, sehingga app timezone harus sama
        date_default_timezone_set('Asia/Jakarta');
        \Carbon\Carbon::setLocale('id');
    }
}
