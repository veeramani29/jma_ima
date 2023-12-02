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
            \URL::forceSchema('https');
            ini_set('memory_limit', '-1');
        }else{
            \URL::forceSchema('http');
        }


        /*  view()->share('pageTitle', 'Expertphp.in');
          view()->composer('*', function ($view) {
               $view->with('pageTitle', 'Expertphp.in');
           });*/
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
