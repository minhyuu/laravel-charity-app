<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        // Force HTTPS in production environment
        if (env('APP_ENV') === 'production') {
            // Trust proxy headers for HTTPS
            \Illuminate\Http\Request::setTrustedProxies(
                [Request::getClientIp()],
                \Illuminate\Http\Request::HEADER_X_FORWARDED_ALL
            );

            URL::forceScheme('https');
        }
    }
}
