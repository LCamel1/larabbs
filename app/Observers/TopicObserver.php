<?php

namespace App\Observers;


use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;

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

        //如 slug字段无内容，即使用翻译器对title 进行翻译
        if (!$topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }

    /**
     * 保存进数据库以后
     */
    public function saved(Topic $topic)
    {
        //
    }
}
