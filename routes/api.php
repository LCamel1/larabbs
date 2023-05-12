<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SmsVerificationCodesController;

use Overtrue\EasySms\EasySms;
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

Route::post("/test", function(){
    //  $expiredAt = now()->addMinutes(5);
    //  return $expiredAt->toDateTimeString();

});




// 短信验证码认证
Route::post('SmsVerificationCodes/store', 'App\Http\Controllers\Api\SmsVerificationCodesController@store')->name('SmsVerificationCodes.store');
