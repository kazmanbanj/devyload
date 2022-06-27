<?php

namespace App\Models;

use App\Models\User;
use ReflectionClass;
use App\Models\Reply;
use App\Service\Visits;
use Illuminate\Support\Str;
use App\Traits\RecordsActivity;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory, RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->slug;
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

        static::created(function ($thread)
        {
            $thread->update(['slug' => $thread->title]);
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
        // (new Spam)->detect($reply->body);

        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        // $this->notifySubscribers($reply);

        return $reply;
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

    public function hasUpdatesFor($user)
    {
        // $key = sprintf("users.%s.visits.%s", auth()->id(), $this->id);
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    // public function visits()
    // {
    //     return new Visits($this);
    // }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }
}
