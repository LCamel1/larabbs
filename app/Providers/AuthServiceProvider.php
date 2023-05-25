<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Laravel\Horizon\Horizon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
		 \App\Models\Topic::class => \App\Policies\TopicPolicy::class,
         \App\Models\Reply::class => \App\Policies\ReplyPolicy::class
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //修改策略自动发现的逻辑
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            // 动态返回模型对应的策略名称，如：//
            return 'App\Policies\\'.class_basename($modelClass).'Policy';
        });



        //horizon 查看队列情况的（项目地址/horizon） 站长才能有查看这个的功能
        Horizon::auth(function ($request) {
            return Auth::user()->hasRole('Founder');
        });
    }
}
