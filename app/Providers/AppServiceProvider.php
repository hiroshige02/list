<?php

namespace App\Providers;

use App\Services\SakeService;
use App\Services\PictureService;
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
        $this->app->singleton(SakeService::class, function ($app) {
            return new SakeService();
        });

        $this->app->singleton(PictureService::class, function ($app) {
            return new PictureService();
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
