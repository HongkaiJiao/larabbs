<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        // 若待通知的人是当前用户，则无需通知，直接返回即可
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        // unreadNotifications--清零user表中的通知数，markAsRead()--修改通知表里的read_at字段为已读时间
        $this->unreadNotifications->markAsRead();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 一个作者拥有多个主题的一对多关系，用来获取到用户发布的所有话题数据
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 鉴权函数
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 一个用户可以拥有多条评论的一对多关系
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
