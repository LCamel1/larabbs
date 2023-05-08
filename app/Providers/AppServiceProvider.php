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
        // app()->isLocal()是 .env 中的 APP_ENV=local ,
        //这个函数就是说：当项目处于本地开发环境下的时候，注册 sudosu 插件提供的服务,
        //即只有本地开发环境才能使用SudoSu
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
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
