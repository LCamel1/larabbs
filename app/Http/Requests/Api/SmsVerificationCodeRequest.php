<?php

namespace App\Http\Requests\Api;

class SmsVerificationCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'captcha_key' => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'captcha_key.required' => '图片验证码 key 不能为空',
            'captcha_code.required' => '图片验证码不能为空',
        ];
    }
}
