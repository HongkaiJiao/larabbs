<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        // XSS 过滤提至控制器内实现
        // $reply->content = clean($reply->content,'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    // 当 Elequont 模型数据成功创建时，created 方法将会被调用
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count',1);

        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        if ($reply->topic->reply_count > 0) {
            $reply->topic->decrement('reply_count',1);
        }
    }
}