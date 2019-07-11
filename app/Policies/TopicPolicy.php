<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy {

    /**
     * 用户id和topic中的user_id对应才能进行操作
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function update(User $user, Topic $topic) {
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic) {
        return $user->isAuthorOf($topic);
    }
}
