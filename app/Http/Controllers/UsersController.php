<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        //过滤未登录用户的 edit, update 动作
        $this->middleware('auth', ['except' => ['show']]);
    }

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
        $this->authorize('update', $user);//权限控制：用户只能编辑自己的资料
        return view('users.edit', compact('user'));
    }

    /**
     * 执行编辑
     */
    public function update(UserRequest $request, User $user, ImageUploadHandler $ImageHandler)
    {
        $this->authorize('update', $user);//权限控制：用户只能编辑自己的资料

        $data = $request->all();
        $update = array();
        $oldAvatar =  public_path().  $user->avatar;
        //config('app.url') .

        foreach ($data as $key => $value) {
            if (($key == 'name') && ($value != $user->name)) {
                //判断修改的用户名是否已存在
                if (User::where('name', '=', $request->name)->first()) {
                    session()->flash('danger', '修改失败，该用户名已存在！');
                    return redirect()->back()->withInput();//返回
                }
                $update['name'] = $request->name;
            } else {
                if ((!in_array($key, ['_method', '_token'])) && ($user->$key != $value)) {
                    $update[$key] = $value;
                }
            }
        }

        //用户头像上传处理
        if ($request->avatar) {
            $image = $ImageHandler->save($request->avatar, 'avatars', $user->id, 416);
            if ($image) {
               $update['avatar'] = $image['path'];
            }
        }

        if (empty($update)) {
            return redirect()->back()->with('warning', '没有需要更新的数据，请先修改！');
        } else {
            if ($user->update($update)) {
                //用户信息更新后删除旧图片
                if (file_exists($oldAvatar)) {
                    @unlink($oldAvatar);
                }

                return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
            } else {
                //用户信息更新后删除旧图片
                if (file_exists($update['avatar'])) {
                    @unlink($update['avatar']);
                }

                return redirect()->back()->with('danget', '个人资料更新失败！');
            }

        }
    }
}
