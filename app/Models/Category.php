<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //设置可以修改的字段白名单
    protected $fillable = [
        'name','description',
    ];
}
