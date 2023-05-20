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

    //访问频率限制每分钟60次
    Route::middleware('throttle:'.config('api.rate_limits.access'))->group(function(){

        /** ****1游客身份可以访问的*** **/
        //分类列表 （资源）
        Route::apiResource('categories', 'App\Http\Controllers\Api\CategoriesController')->only('index');

        //某个用户发布的话题
        Route::get('users/{user}/topics', 'App\Http\Controllers\Api\TopicsController@userIndex');

        //话题 列表，详情 （资源）
        Route::apiResource('topics', 'App\Http\Controllers\Api\TopicsController')->only(['index','show']);

        //话题回复列表 （资源）
        Route::apiResource('topics.replies', 'App\Http\Controllers\Api\RepliesController')->only(['index']);

        //某个用户的回复列表
        Route::get('users/{user}/replies', 'App\Http\Controllers\Api\RepliesController@userIndex');

        //资源推荐列表 （资源）
        Route::apiResource('links', 'App\Http\Controllers\Api\LinksController')->only(['index']);

        //活跃用户
        Route::get('actived/users', 'App\Http\Controllers\Api\UsersController@activedIndex');

        //一用户的详情信息
        Route::get('users/{user}', 'App\Http\Controllers\Api\UsersController@show');

        /****2已登录用户可以访问的****/
        Route::middleware('auth:api')->group(function(){
            //当前登录用户的信息
            Route::get('user', 'App\Http\Controllers\Api\UsersController@me');

            //编辑登录用户信息
            Route::patch('user', 'App\Http\Controllers\Api\UsersController@update');

            //图片上传
            Route::post('image', 'App\Http\Controllers\Api\ImagesController@store');

            //发布，修改，删除话题（资源
            Route::apiResource('topics', 'App\Http\Controllers\Api\TopicsController')->only(['store','update', 'destroy']);

            //发布，删除回复 （资源）
            Route::apiResource('topics.replies', 'App\Http\Controllers\Api\RepliesController')->only(['store', 'destroy']);

            //通知列表（资源）

            //通知统计

            //标记通知消息已读

            //当前登录用户权限
        });

    });

});







