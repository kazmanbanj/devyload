<?php

namespace App\Models;

use App\Events\ThreadReceivedNewReply;
use App\Service\Visits;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Thread extends Model
{
    use HasFactory, RecordsActivity, Searchable;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        self::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected $casts = [
        'locked' => 'boolean',
    ];

    public function path()
    {
        return "/threads/{$this->channel->slug}/$this->slug";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReplies($replies)
    {
        foreach ($replies as $reply) {
            $this->addReply($reply);
        }
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($this, $reply));

        return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()
            ->create([
                'user_id' => $userId ?: auth()->id(),
            ]);

        return $this;
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

    protected function isSubscribedTo($userId = null)
    {
        return $this->subscriptions()->where('user_id', $userId ?: auth()->id())->exists();
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->isSubscribedTo();
    }

    public function hasUpdates($user)
    {
        if (! \Auth::check()) {
            return true;
        }

        $key = \Auth::user()->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * Lock a thread from receiving replies.
     *
     * @return bool
     */
    public function lock()
    {
        return $this->update([
            'is_locked' => true,
        ]);
    }

    /**
     * Unlock a thread from receiving replies.
     *
     * @return bool
     */
    public function unlock()
    {
        return $this->update([
            'is_locked' => false,
        ]);
    }

    public function visits()
    {
        return new Visits($this);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Increment a slug's suffix.
     *
     * @param  string  $slug
     * @return string
     */
    protected function incrementSlug($slug, $count = 2)
    {
        $original = $slug;

        while (static::whereSlug($slug)->exists()) {
            $slug = $original.'-'.$count;
        }

        return $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $reply->thread->update([
            'best_reply_id' => $reply->id,
        ]);
    }
}
