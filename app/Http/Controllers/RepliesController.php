<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $channelId, Reply $reply)
    {
        // dd($request->all());
        $reply->addReply([
            'body' => $request['body'],
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
