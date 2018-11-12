<?php

namespace App\Models;

class Reply extends Model
{
    // 只允许用户更改 content 字段
    protected $fillable = ['content'];

    // 关联数据模型：一条回复属于一个话题的一对一关系
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // 关联数据模型：一条回复从属于一个作者的一对一关系
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
