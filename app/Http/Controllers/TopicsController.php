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
	public function list(string $type = 'i', int $id = 0)
	{
        $topics = '';
        $category = '';
        if ($type == 'c' && $id != 0) {
             $topics = DB::table('topics')->rightJoin('users', 'topics.user_id', '=', 'users.id')
                          ->select('topics.*','users.avatar','users.name as user_name')
                          ->where('category_id',$id)
                          ->paginate();

            $category = Category::find($id);
        } else {
             $topics = DB::table('topics')->Join('users', 'topics.user_id', '=', 'users.id')
                          ->Join('categories', 'topics.category_id', '=', 'categories.id')
                          ->select('topics.*','users.avatar','users.name as user_name','categories.name as category_name')
                          ->paginate();
        }

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
