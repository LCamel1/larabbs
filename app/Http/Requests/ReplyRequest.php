<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|min:2',
        ];
    }

    public function message()
    {
        return [
            'content.required' => '内容不能为空',
            'content.min' => '内容要两个字符以上',
        ];

    }
}
