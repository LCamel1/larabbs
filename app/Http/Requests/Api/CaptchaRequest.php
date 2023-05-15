<?php

namespace App\Http\Requests\Api;

class CaptchaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|phone:CN,mobile|unique:users',
        ];
    }
}
