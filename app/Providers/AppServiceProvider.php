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
          return Auth::user()->hasRole('associazione') || Auth::user()->hasRole('Referente Associazione') || Auth::user()->hasRole('GGV Avanzato') || Auth::user()->hasRole('GGV Semplice');
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
