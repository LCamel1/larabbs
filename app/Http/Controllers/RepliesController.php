<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        //权限：只有登录的用户才能回复
        $this->middleware('auth');
    }

    public function store(Request $request, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
    }

    public function destroy(Reply $reply)
    {
        //用户只能删除自己的回复
        $this->authorize('destroy', $reply);

        $reply->delete();

        return redirect()->to($reply->topic->link())->with('success', '评论删除成功！');
    }
}
