<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kavenegar\KavenegarApi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(KavenegarApi::class, function ($app) {
            return new KavenegarApi(env('KAVENEGAR_API'));
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
