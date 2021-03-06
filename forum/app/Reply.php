<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class Reply extends Model
{
    use Favoritable,RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner','favorites'];

    protected $appends = ['favoritesCount','isFavorited','isBest'];

    protected static function boot()
    {
        parent::boot(); //

        static::created(function ($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply){
            if($reply->id == $reply->thread->best_reply_id){
                $reply->thread->update(['best_reply_id' => null]);
            }

            $reply->thread->decrement('replies_count');
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');  // 使用 user_id 字段进行模型关联
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/','<a href="/profiles/$1">$0</a>',$body);
    }

    public function getBodyAttribute($body)
    {
        return clean($body);
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/',$this->body,$matches);

        return $matches[1];
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }
}