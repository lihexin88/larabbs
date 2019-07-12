<?php

namespace App\Models;

class Topic extends Model {
    protected $fillable = [
        'title', 'body', 'category_id', 'excerpt', 'slug'
    ];

    /**
     * 以下两个方法，为定义topic模型的对应关系，为数据库中的外键
     */

    /**
     * 一个话题属于一个分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }


    /**
     * 一个话题属于一个用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order) {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query) {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query) {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }


    public function link($params = []) {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    /**
     * 一个话题可以拥有多个回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies() {
        return $this->hasMany(Reply::class);
    }

    /**
     *  回复数统计，在创建之后和删除之后进行统计
     */
    public function updateReplyCount() {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
