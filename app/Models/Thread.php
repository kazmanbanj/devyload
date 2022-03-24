<?php

namespace App\Models;

use App\Models\User;
use ReflectionClass;
use App\Models\Reply;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = ["user_id", "channel_id", "title", "body"];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function ($builder)
        // {
        //     $builder->withCount('replies');
        // });

        static::deleting(function ($thread)
        {
            // $thread->replies()->each()->delete();
            $thread->replies()->each(function ($reply) {
                $reply->delete();
            });
        });
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('creator');
    }

    // public function getReplyCountAttribute()
    // {
    //     return $this->replies()->count();
    // }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        return $this->replies()->create($reply);

        // event(new ThreadHasNewReply($this, $reply));
        $this->notifySubscribers($reply);

        return $reply;
    }

    public function notifySubscribers($reply)
    {
        $this->subscribers
            ->where('user_id', '!=', $reply->user_id)
            ->each
            ->notify($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
        ->where('user_id', $userId ?: auth()->id())
        ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor()
    {
        $key = sprintf("users.%s.visits.%s", auth()->id(), $this->id);

        return $this->updated_at > cache($key);
    }
}
