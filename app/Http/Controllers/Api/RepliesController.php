<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Reply;
use App\Http\Requests\Api\ReplyRequest;
use App\Http\Resources\ReplyResource;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class RepliesController extends Controller
{

    public $query;

    public function __construct()
    {
        $this->query = QueryBuilder::for(Reply::class)
            ->allowedIncludes('user', 'topic', 'topic.user'); //可以被include的参数
    }

    public function index($topicId)
    {
        $replies = $this->query->where('topic_id', $topicId)->paginate();

        return ReplyResource::collection($replies);
    }

    public function userIndex($userId)
    {
        $replies = $this->query->where('user_id', $userId)->paginate();

        return ReplyResource::collection($replies);
    }

    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->topic()->associate($topic);//associate 的作用是传入关联模型的 id 值。比如 $reply->topic()->associate($topic);，因为 Reply 模型关联了 Topic 模型，这里的作用就是把当前要回复的话题 id 赋值给 Reply 模型的 topic_id 字段
        $reply->user()->associate($request->user());

        return new ReplyResource($reply);
    }

    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id != $topic->id) {
            abort(404);
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return response(null, 204);
    }
}
