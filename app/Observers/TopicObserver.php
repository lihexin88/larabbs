<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver {
    /**
     * 创建话题时候，过滤xss注入信息，生成话题摘录
     * @param Topic $topic
     */
    public function saving(Topic $topic) {
        // XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    /**
     * 话题创建的时候，检索关键字进行翻译，并写进title
     * @param Topic $topic
     */
    public function saved(Topic $topic) {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (!$topic->slug) {
            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    /**
     * 删除话题顺带删除该话题的所有回复
     * @param Topic $topic
     */
    public function deleted(Topic $topic) {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
