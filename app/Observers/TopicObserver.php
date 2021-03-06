<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        // 使用HTMLpurifier过滤用户提交的数据 xss 过滤
        $topic->body = clean($topic->body,'user_topic_body');
        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

    }

    /* 该模型监控器的 saved 方法对应 Eloquent 的 saved 事件，此事件发生在创建和编辑时、数据入库以后；
     *
     * */
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (!$topic->slug) {
            // $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);

            // 推送任务到队列 -- 在 saved 方法中调用，确保了我们在分发任务时，$topic->id 永远有值
            dispatch( new TranslateSlug($topic));
        }
    }

    /* ★★★在模型监听器中，数据库操作需要避免再次 Eloquent 事件，所以此处我们使用 DB 类进行操作
     * 即：不可以使用：$topic->replies()->delete();从而再次触发模型监听器的 deleted 事件以至于陷入死循环
    */
    public function deleted(Topic $topic)
    {
        // 在话题被删除的同时，删除与该话题相关的所有回复
        \DB::table('replies')->where('topic_id',$topic->id)->delete();
    }
}