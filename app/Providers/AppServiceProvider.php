<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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

        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        
        /**
         * https://laravel-news.com/laravel-5-4-key-too-long-error
         * SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes
         */
        Schema::defaultStringLength(191);


        Blade::if('isAdmin', function () 
          {
          return Auth::user()->hasRole('admin');
          });

        Blade::if('isAssoc', function () 
          {
          return Auth::user()->hasRole(['associazione','Referente Associazione','GGV Avanzato','GGV Semplice']);
          });

        setlocale(LC_TIME, "it_IT.utf8");
        
        // Localization Carbon
        \Carbon\Carbon::setLocale(config('app.locale'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
