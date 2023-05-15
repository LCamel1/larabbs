<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return [
        //     'verification_key' => '短信验证码 key',
        //     'verification_code' => '短信验证码',
        // ];
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
                    'password' => 'required|string|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':

                break;
            default:
                # code...
                break;
        }
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写；',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线；',
            'name.between' => '用户名必须介于 3 - 25 个字符之间；',
            'name.required' => '用户名不能为空；',
        ];
    }
}
