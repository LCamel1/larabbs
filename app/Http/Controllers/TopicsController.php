<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['list', 'show']]);
    }

    /**
     * 话题列表页
     */
	public function list(Request $request)
	{
        $type = $request->get('type', 'i');
        $id = $request->get('id', 0);
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
        $order =  $request->get('order', 1);
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

		return view('topics.index', compact('topics', 'category'));
	}

    /**
     * 单个话题查看页
     */
    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
		return view('topics.create_and_edit', compact('topic'));
	}

	public function store(TopicRequest $request)
	{
		$topic = Topic::create($request->all());
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}
