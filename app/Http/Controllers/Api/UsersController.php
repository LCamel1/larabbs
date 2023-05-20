<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;

class UsersController extends Controller
{
    /**
     * 用户注册
     * 逻辑：用户注册 前面已经做了 图片验证(防短信攻击)->手机短信验证
     */
    public function store(Request $request)
    {
        //获取缓存信息
        $verifyData = \Cache::get($request->verification_key);
        //判断短信验证码是否已失效
        if (!$verifyData) {
            abort(403, ' 短信验证码已失效');
        }

        //判断用户输入的验证码是否正确 (hash_equals() ->比较两个字符串是否相等)
        if (!hash_equals($request->verification_code, $verifyData['code'])) {
            //返回401
            throw new AuthenticationException('短信验证码错误');
        }
        //创建用户
        $user = User::create([
            'name' => $request->name,
            'phone' =>$verifyData['phone'],
            'password' =>$request->password,
        ]);
        //清除验证码缓存
        \Cache::forget($request->verification_key);

        return (new UserResource($user))->showSensitiveFields();
    }

    /**
     *  根据ID获取一用户的信息
     */
    public function show(User $user, Request $request)
    {
        return new UserResourse($user);
    }

    /**
     * 获取当前登录用户的信息
     */
    public function me(Request $request)
    {
        return (new UserResource($request->user()))->showSensitiveFields();
    }
    /*
     * 编辑个人信息
     */
    public function update(UserRequest $request)
    {
        $user = $request->user();
        $attributes = $request->only(['name', 'email', 'introduction']);

        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }
        $user->update($attributes);

        return (new UserResource($user))->showSensitiveFields();
    }

}
