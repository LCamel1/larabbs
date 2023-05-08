<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\TopicsController@index')->name('home');

//Auth::routes(); //等同于下面
//用户身份验证相关路由
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
//用户注册相关路由
Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
//密码重置相关路由
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
//Email认证相关路由
Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

//=====================================================================================

Route::resource('users', 'App\Http\Controllers\UsersController', ['only'=>['show', 'edit', 'update']]);

Route::resource('topics', 'App\Http\Controllers\TopicsController', ['only' => ['create', 'store', 'update', 'edit', 'destroy']]);

Route::get('topics/list/{type}/{id?}', 'App\Http\Controllers\TopicsController@index')->name('topics.list');

Route::post('upload_image', 'App\Http\Controllers\TopicsController@uploadImage')->name('topics.upload_image');

Route::get('topics/{topic}/{slug?}', 'App\Http\Controllers\TopicsController@show')->name('topics.show');

//回复
Route::resource('replies', 'App\Http\Controllers\RepliesController', ['only' => ['store', 'destroy']]);

//消息通知查看页面
Route::resource('notifications', 'App\Http\Controllers\NotificationsController', ['only' => ['index']]);

Route::get('permission-denied', 'App\Http\Controllers\StaticPagesController@permissionDenied')->name('permission-denied');
