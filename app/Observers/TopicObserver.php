<?php

namespace App\Observers;
use App\Jobs\TranslateSlug;
use Illuminate\Support\Facades\DB;


use App\Models\Topic;
// use App\Handlers\SlugTranslateHandler;


// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    /**
     * 保存存进数据库前
     */
    public function saving(Topic $topic)
    {
        //XSS 过滤
        $topic->content = clean($topic->content, 'user_topic_body');
        //生成话题摘录
        $topic->excerpt = make_excerpt($topic->content);

        //如 slug字段无内容，即使用翻译器对title 进行翻译(没用队列之前使用这种同步保存slug信息)
        // if (!$topic->slug) {
        //     $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        // }
    }

    /**
     * 保存进数据库以后
     */
    public function saved(Topic $topic)
    {
        //使用队列 实现异步修改slug 从而不影响用户创建话题
        if (!$topic->slug) {
            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    /**
     * 删除数据之后
     */
    public function deleted(Topic $topic)
    {
        //当用户删除话题数据之后，要把它相应的回复也删掉
        //DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
