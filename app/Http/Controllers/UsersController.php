<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * 个人中心
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 用户编辑页面
     */
    public function edit()
    {
        return view('users.edit');
    }

    /**
     * 执行编辑
     */
    public function update()
    {

    }
}
