<?php

namespace App\Observers;


use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        //XSS 过滤
        $topic->content = clean($topic->content, 'user_topic_body');

        $topic->excerpt = make_excerpt($topic->content);
    }

    public function updating(Topic $topic)
    {
        //
    }
}
