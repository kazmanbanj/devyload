<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Fetch an activity feed for the given user.
     *
     * @param  User $user
     * @param  int  $take
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public static function feed($user, $take = 50)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
