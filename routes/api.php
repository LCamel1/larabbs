<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('test', function(){

    echo 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6ec0ff450aa16e24&redirect_uri=http%3A%2F%2Fbbs.test&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';

    $code = '001FcOkl285Tjb4adOml2hQtRb1FcOkS';
});

Route::prefix('v1')->group(function(){

    //通过中间件加上登录频率限制，防止攻击throttle:10,1 次数。分钟
    Route::middleware('throttle:'. config('api.rate_limits.sign'))->group(function(){
        //生成图片验证码
        Route::post('captchas', 'App\Http\Controllers\Api\captchasController@store');
        // 短信验证码认证
        Route::post('verification_codes', 'App\Http\Controllers\Api\SmsVerificationCodesController@store');
        //用户注册
        Route::post('users', 'App\Http\Controllers\Api\UsersController@store');

        //第三方登录
        Route::post('socials/{social_type}/authorizations', 'App\Http\Controllers\Api\AuthorizationsController@socialStore')->name('socials.authorizations.store');

        //登录
        Route::post('authorizations', 'App\Http\Controllers\Api\AuthorizationsController@store');

        //刷新token
        Route::put('authorizations/current', 'App\Http\Controllers\Api\AuthorizationsController@update');

        //删除token
        Route::delete('authorizations/current', 'App\Http\Controllers\Api\AuthorizationsController@destroy');
    });

});







