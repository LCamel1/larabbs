<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mews\Captcha\Captcha;
use App\Http\Requests\Api\CaptchaRequest;
use  Illuminate\Support\Str;

class CaptchasController extends Controller
{
    /**
     * 生成验证码图片
     */
    public function store(Request $request, Captcha $CaptchaCreate)
    {
        $key = 'code-' . Str::random(15); //生成缓存key
        $phone = $request->phone;

        $captcha = $CaptchaCreate->create('flat', true);

        $expiredAt = now()->addMinutes(2);

        \Cache::put($key, ['phone' => $phone, 'captcha' => $captcha['key']], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_img' => $captcha['img'],

        ];

        return response()->json($result)->setStatusCode(201);
    }
}
