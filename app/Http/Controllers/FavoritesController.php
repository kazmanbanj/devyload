<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        if (!$reply->favorites()->where(['user_id' => auth()->id()])->exists()) {
            Favorite::create([
                'user_id' => auth()->user()->id,
                'favorited_id' => $reply->id,
                'favorited_type' => get_class($reply)
            ]);
        }

        // $reply->favorite();

        return redirect()->back();
    }
}
