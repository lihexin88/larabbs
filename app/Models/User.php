<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

class User extends Authenticatable implements MustVerifyEmailContract {
    use Notifiable, MustVerifyEmailTrait;

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
    public function replies(){
        return $this->hasMany(Reply::class);
    }
}
