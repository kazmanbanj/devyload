<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "channel_id", "title", "body"];

    public function path()
    {
        return '/threads/{$this->channel->slug}/{$this->id}';
        // return '/threads/' . $this->channel->slug . '/' . $this->id;
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder)
        {
            $builder->withCount('replies');
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
        $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
