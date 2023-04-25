<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //判断：1.用户是否已登录 2.是否还没认证email 3.访问的不是email验证URL或退出URL
        if ($request->user() && !$request->user()->hasVerifiedEmail() && !$request->is('email/*', 'logout')) {
            //根据客户端返回对应的内容
            return $request->expectsJson()
             ? abort(403, 'Your email address is not verified.')
             : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
