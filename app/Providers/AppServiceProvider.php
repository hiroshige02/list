<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SakeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton('App\SampleClass');


        $this->app->singleton(SakeService::class, function ($app) {
            return new SakeService();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
