<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;

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
        // if (Gate::denies('create', new Reply)) {
        //     return response('You are posting too frequently. Please take a break.', 422);
        // };
        // $thread = Thread::findOrFail($threadId);

        // $reply = $form->persist($thread);
        // dd(request()->all());
        // Log::info(request()->all());
        $reply = $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id(),
            // 'thread_id' => $this->thread->id,
        ]);

        // return $thread->addReply([
        //     'body' => request('body'),
        //     'user_id' => auth()->id()
        // ])->load('owner');


        
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

        return $reply->load('creator');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

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

    protected function validateReply()
    {
        $this->validate(request(), ['body' => 'required|spamfree']);
    }
}
