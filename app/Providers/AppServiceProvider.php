<?php

namespace App\Providers;

use App\Models\Instansi;
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
        view()->composer('*', function ($instansi) {
            $instansi->with('instansi', Instansi::first());
        });
    }
}
