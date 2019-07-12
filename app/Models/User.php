<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

use Auth;

class User extends Authenticatable implements MustVerifyEmailContract {
    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance) {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

//    允许用户进行修改的字段
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAuthorOf($model) {
        return $this->id == $model->user_id;
    }


    /**
     * 用户-话题一对多关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics() {
        return $this->hasMany(Topic::class);
    }


    /**
     * 一个用户可以拥有多个回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies() {
        return $this->hasMany(Reply::class);
    }

    /**
     *标记为已读状态
     */
    public function markAsRead() {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
