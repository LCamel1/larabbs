<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    /**
     * 新建评论前 XXS过滤
     */
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'bbs_topic_reply');
    }

    /**
     * 新建评论后 1.修改话题评论的总数字段数据 2给话题作者 发通知有新的评论
     */
    public function created(Reply $reply)
    {
        //1.修改话题评论的总数字段数据
        $reply->topic->updateReplyCount();

        //2给话题作者 发通知有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    /**
     *  删除后 修改话题评论总数字段数据
     */
    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}
