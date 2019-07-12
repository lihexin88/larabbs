<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver {
    /**
     * 事件监控，在创建回复之后，进行操作
     * @param Reply $reply
     */
    public function created(Reply $reply) {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }

    /**
     *事件监控，在新的回复创建的时候，进行操作
     * 对回复的提交数据过滤
     * @param Reply $reply
     */
    public function creating(Reply $reply) {
        $reply->content = clean($reply->content, 'user_topic_body');
    }
}
