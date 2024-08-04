<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;


class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        //
    }

    
    public function boot()
{
    Carbon::setLocale(config('app.locale'));
    date_default_timezone_set('America/Bogota');
}

}
