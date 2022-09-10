<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\Activity;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'confirmed' => 'boolean'
    ];

    /**
     * Get all of the threads for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? '/storage/'.$avatar : 'images/avatars/default.png');
    }
    
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        
        $this->save();
    }

    public function isAdmin()
    {
        return in_array($this->name, ['jahojaho', 'jahojaho1']);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    public function read($thread)
    {
        return cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }
}
