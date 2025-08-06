<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Reply;
use App\Models\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(15);
    }

    public function store($channelId, Thread $thread, CreatePostRequest $request)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }
        $request = $request->validated();
        $reply = $thread->addReply([
            'body' => $request['body'],
            'user_id' => auth()->id(),
        ])->load('creator');

        // return $thread->addReply([
        //     'body' => request('body'),
        //     'user_id' => auth()->id()
        // ])->load('owner');

        // $thread->subscriptions->filter(function ($sub) use ($reply) {
        //     return $sub->user_id != $reply->user_id;
        // })
        // ->each->notify($reply);

        // DatabaseNotification::create([
        //     'id' => Uuid::uuid4()->toString(),
        //     'type' => 'App\Notifications\ThreadWasUpdated',
        //     'notifiable_type' => function () {
        //         return auth()->id() ?: factory('App\User')->create()->id;
        //     },
        //     'notifiable_id' => 'App\User',
        //     'data' => ['title' => 'this is the body of the notification']
        // ]);

        return $reply;
    }

    public function update(Reply $reply, Request $request)
    {
        $this->authorize('update', $reply);

        $this->validate($request, [
            'body' => ['required', 'string', new SpamFree],
        ]);

        $reply->update([
            'body' => $request['body']]
        );

        return response([], 200);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return response([], 200);
    }
}
