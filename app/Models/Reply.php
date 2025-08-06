<?php

namespace App\Models;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, HasFactory, RecordsActivity;

    protected static function boot()
    {
        parent::boot();

        // static::created(function ($reply) {
        //     $reply->thread->increment('replies_count');
        // });

        // static::deleted(function ($reply) {
        //     $reply->thread->decrement('replies_count');
        // });
    }

    protected $guarded = [];

    protected $with = ['creator', 'favorites'];

    protected $appends = ['favorites_count', 'is_favorited', 'isBest'];

    protected $touches = ['thread'];

    /**
     * Get the user that owns the Reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the thread that owns the Reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path()."#reply-{$this->id}";
    }

    public function wasJustPublished()
    {
        return $this->created_at->greaterThanOrEqualTo(now()->subSeconds(60));
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-\_]+)/', $this->body, $matches);

        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-\_]+)/', '<a href="/profiles/$1">$0</a>', $body);
    }

    public function isBest()
    {
        return $this->id == $this->thread->best_reply_id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }
}
