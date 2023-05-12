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

    public function store(Request $request)
    {
        //验证传参合法性

        $easySms = new EasySms(config('easysms'));
        $mobile = trim($request->mobile);
        //验证码生成
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        // 通过easySms扩展包发送验证码短信
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
