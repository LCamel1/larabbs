<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * 个人中心
     */
    public function show(User $user)
    {
        $user->created_at_str = $user->created_at->diffForHumans();
        $user->updated_at_str = $user->updated_at->diffForHumans();

        return view('users.show', compact('user'));
    }

    /**
     * 用户编辑页面
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * 执行编辑
     */
    public function update(UserRequest $request, User $user)
    {

        $data = $request->all();
        $update = array();

        foreach ($data as $key => $value) {
            if ((!in_array($key, ['_method', '_token'])) && ($user->$key != $value)) {
               $update[$key] = $value;
            }
        }
        if (empty($update)) {
            return redirect()->back()->with('warning', '没有需要更新的数据，请先修改！');
        } else {
            if ($user->update($update)) {
                return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
            } else {
                 return redirect()->back()->with('danget', '个人资料更新失败！');
            }

        }
    }
}
