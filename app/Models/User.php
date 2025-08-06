<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'avatar_path',
    ];

    protected $appends = ['avatar'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'confirmed' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Get all of the threads for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function avatar()
    {
        return $this->avatar_path ? '/storage/'.$this->avatar_path : '/storage/avatars/default.png';
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

    public function getAvatarAttribute()
    {
        return $this->avatar();
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
        return sprintf('users.%s.visits.%s', $this->id, $thread->id);
    }

    public function seen($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread), Carbon::now()
        );

        return $this;
    }

    public function read($thread)
    {
        return cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }
}
