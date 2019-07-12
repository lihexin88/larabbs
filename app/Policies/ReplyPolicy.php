<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy {
    /**
     * 话题的创作者或者回复者可以删除
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function destroy(User $user, Reply $reply) {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
