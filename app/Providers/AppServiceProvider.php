<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFour(); //分页使用bootstrap的

        //注册观察类 Observe（话题的监控类）
        \App\Models\Topic::observe(\App\Observers\TopicObserver::class);
        \App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
    }
}
