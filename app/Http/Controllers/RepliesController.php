<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, $threadId)
    {
        $thread = Thread::find($threadId);

        return $thread->replies()->paginate(20);
    }

    public function store(ReplyRequest $request, $channelId, $threadId, Reply $reply)
    {
        $reply = $reply->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
            'thread_id' => $threadId,
        ]);

        // $reply->thread->increment('replies_count');

        if (request()->expectsJson()) {
            return $reply->load('creator');
        }

        return back()->with('flash', 'Your reply has been left!');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        // if ($reply->user_id != auth()->id()) {
        //     abort(403);
        // }

        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return redirect()->back();
    }
}
