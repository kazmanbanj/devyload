<?php

namespace App\Models;

use App\Models\Favorite;
use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $fillable = [
        'body',
        'thread_id',
        'user_id',
    ];

    protected $with = ['creator', 'favorites'];

    /**
     * Get the user that owns the Reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
