<?php
use App\modulo;
use App\Observers\moduloObserver;
namespace App\Providers;
use Carbon\Carbon;


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
        Carbon::setLocale(config('app.locale'));
        \App\modulo::observe(\App\Observers\moduloObserver::class);
        \App\User::observe(\App\Observers\UserObserver::class);
        \App\documento::observe(\App\Observers\documentoObserver::class);
        \App\Restore::observe(\App\Observers\restoreObserver::class);
    }
}
