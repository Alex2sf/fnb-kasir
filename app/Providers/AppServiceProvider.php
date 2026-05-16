<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('path.public', function() {
            // Jika ada folder public_html di luar folder project (standard cPanel)
            $hostingPath = base_path('../public_html');
            if (is_dir($hostingPath)) {
                return $hostingPath;
            }
            // Fallback ke folder public standar jika di lokal
            return base_path('public');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
