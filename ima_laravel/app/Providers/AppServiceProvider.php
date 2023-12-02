<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV')=='production') {
            set_error_handler(null);
            set_exception_handler(null);
            error_reporting(0);
            \URL::forceScheme('https');
            ini_set('memory_limit', '-1');
        }else{
            \URL::forceScheme('http');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // require_once __DIR__ . '/../Http/helpers.php';
        require_once __DIR__ . '/../../config/constants.php';
        require_once __DIR__ . '/../../config/'.app()->environment().'/ConfigKeys.php';
    }
}
