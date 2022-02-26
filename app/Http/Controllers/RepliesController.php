<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(ReplyRequest $request, $channelId, $threadId, Reply $reply)
    {
        $reply->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
            'thread_id' => $threadId,
        ]);

        return back();
    }
}
