<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    /**
     * 限制用户只能进行自己的信息修改
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function update(/*当前用户：*/ User $currentUser,/*需要进行授权验证的用户信息：*/   User $user) {
        return $currentUser->id === $user->id;
    }
}
