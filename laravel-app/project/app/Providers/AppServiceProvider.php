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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        date_default_timezone_set('Asia/Manila');
        define('BASEURL', env('APP_URL'));
        define('SQLDATETIME', 'Y-m-d H:i:s');
        define('SQLDATE', 'Y-m-d');
        define('LONGDATE', 'F j, Y');
        define('LONGDATETIME', 'F j, Y, g:i a');
        define('TIMEF', 'g:i A');
        define('LOGO', 'official_logo.jpg');
    }
}
