<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Ramsey\Uuid\Uuid;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;
use Illuminate\Notifications\DatabaseNotification;

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
        $thread = Thread::findOrFail($threadId);

        $reply = $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id(),
            'thread_id' => $threadId,
        ]);

        // $reply->thread->increment('replies_count');

        if (request()->expectsJson()) {
            return $reply->load('creator');
        }

        
        $thread->subscriptions->filter(function ($sub) use ($reply) {
            return $sub->user_id != $reply->user_id;
        })
        ->each->notify($reply);

        // DatabaseNotification::create([
        //     'id' => Uuid::uuid4()->toString(),
        //     'type' => 'App\Notifications\ThreadWasUpdated',
        //     'notifiable_type' => function () {
        //         return auth()->id() ?: factory('App\User')->create()->id;
        //     },
        //     'notifiable_id' => 'App\User',
        //     'data' => ['title' => 'this is the body of the notification']
        // ]);

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
