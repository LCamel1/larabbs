<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Models\User;
use App\Models\Topic;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TopicsController extends Controller
{
    public $query;

    public function __construct()
    {
        $this->query = QueryBuilder::for(Topic::class)
            ->allowedIncludes('user', 'user.roles', 'category') //可以被include的参数
            ->allowedFilters([ //允许过滤搜索的字段
                'title', //模糊搜索title
                AllowedFilter::exact('category_id'), //精确搜索category_id字段
                //AllowedFilter::scope('withOrder')->default('recentReplied'),  //本地作用域，传递默认参数
            ]);
    }
    /**
     * 话题列表
     */
    public function index()
    {
        $topics = $this->query->paginate();
        return TopicResource::collection($topics);
    }

    /**
     * 一用户话题
     */
    public function userIndex(Request $request, User $user)
    {
        $topics = $this->query->where('user_id', $user->id)->paginate();

        return TopicResource::collection($topics);
    }

    /**
     * 话题详情
     */
    public function show($topicId)
    {
        $topic = $this->query->findOrFail($topicId);
        return new TopicResource($topic);
    }

    /**
     * 新增话题
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    /**
     * 编辑话题（自己才能编辑）
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->update($request->all());
        return new TopicResource($topic);
    }


    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $topic->delete();

        return response(null, 204);
    }


}
