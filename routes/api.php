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
Route::prefix('v1')->group(function(){

    //通过中间件加上登录频率限制，防止攻击throttle:10,1
    Route::middleware('throttle:'. config('api.rate_limits.sign'))->group(function(){
        //生成图片验证码
        Route::post('captchas', 'App\Http\Controllers\Api\captchasController@store');
        // 短信验证码认证
        Route::post('verification_codes', 'App\Http\Controllers\Api\SmsVerificationCodesController@store');
        //用户注册
        Route::post('users', 'App\Http\Controllers\Api\UsersController@store');
    });

});







