<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;
use App\Http\Requests\Api\SmsVerificationCodeRequest;

class SmsVerificationCodesController extends Controller
{

    public function store(SmsVerificationCodeRequest $request)
    {
        //1.先判断图片验证码是否正确
        $captchaData = \Cache::get($request->captcha_key);
        if (!$captchaData) {
            abort(403, '图片验证码已失效');
        }

        // 调用captcha_api_check() 判断用户输入的验证码是否和缓存key中的一样
        //captcha_api_check()是[mews/captcha] 提供的辅助方法
        if (!captcha_api_check($request->captcha_code, $captchaData['captcha'], 'flat')) {
            //图片验证码错误，清除缓存
            \Cache::forget($request->captcha_key);
            throw new AuthenticationException('验证码错误');
        }

        //2.生成手机验证码，并发送短信至用户手机号码上
        $mobile = $captchaData['phone'];

        $easySms = new EasySms(config('easysms'));

        //验证码生成
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        // 通过easySms扩展包发送验证码短信
        if (!app()->environment('production')) {  // 非生产环境 不发短信
            $code = '1234';
        } else {
            try {
                    $easySms->send($mobile, [
                        'template' => config('easysms.gateways.qcloud.template_id'), // 你在腾讯云配置的"短信正文”的模板ID
                        'data' => [
                            'code' => $code
                        ]
                   ]);
            } catch(\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception){
                $message = $exception->getException('yunpian')->getMessage();
                abort(500, $message ?: '短信发送异常');
            }
        }

        $key = 'verificationCode_'.Str::random(15);
        $expiredAt = now()->addMinutes(5);

        //缓存验证码 5分钟后过期
        \Cache::put($key, ['phone' => $mobile, 'code' => $code], $expiredAt);

        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }

}
