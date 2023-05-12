<?php

namespace App\Providers;

use Overture\EasySms\EasySms;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class EasySmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(EasySms::class, function (Application $app) {
            return new EasySms(config('easysms'));
        });

        $this->app->alias(EasySms::class, 'easysms');
    }
}
