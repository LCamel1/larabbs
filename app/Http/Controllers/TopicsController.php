<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Handlers\ImageUploadHandler;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Link;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * 话题列表页
     */
	public function index(Request $request, User $user, Link $link)
	{
        $type = $request->type;
        $id = $request->id;
        $category = '';
        $topics = DB::table('topics')->Join('users', 'topics.user_id', '=', 'users.id')
                                    ->select('topics.*','users.avatar','users.name as user_name');
        if ($type == 'c' && $id != 0) {
             $topics = $topics->where('category_id',$id);

            $category = Category::find($id);
        } else {
             $topics = $topics->Join('categories', 'topics.category_id', '=', 'categories.id')
                              ->addSelect('categories.name as category_name');
        }
        $order =  $request->order;
        //排序
        switch ($order) {
            case 2:
                $topics = $topics-> orderBy('topics.created_at', 'desc');
                break;
            case 1:
            default:
                $topics = $topics-> orderBy('topics.updated_at', 'desc');
                break;
        }

        $topics = $topics->paginate();

        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();

        return view('topics.index', compact('topics', 'active_users', 'links'));
	}

    /**
     * 单个话题查看页
     */
    public function show(Request $request, Topic $topic)
    {
        //防止用户恶意输入
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);//301 永久重定向到正确的 URL 上
        }
        return view('topics.show', compact('topic'));
    }

    /**
     * 创建话题页面
     */
	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

    /**
     * 新建话题
     */
	public function store(TopicRequest $request, Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id =Auth::id();
		$topic->save();
		return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);

		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);

		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('success', '修改成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.list', ['i'])->with('success', '删除成功！');
	}

    /**
     * 编辑器上传文件
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'errno'=> 1,
            'message'=> '上传失败!',
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->topic_upload_image) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topics', Auth::id(), 300); //AUth::id 获取当前用户ID
            // 图片保存成功的话
            if ($result) {
                $data['data']['url'] = $result['path'];
                $data['message']       = "上传成功!";
                $data['errno']   = 0;
            }
        }
        return $data;
    }
}
