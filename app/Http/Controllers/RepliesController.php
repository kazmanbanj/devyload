<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reply;
use Ramsey\Uuid\Uuid;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Forms\CreatePostForm;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Gate;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
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

    public function store($channelId, $threadId, CreatePostForm $form)
    {
        // if (Gate::denies('create', new Reply)) {
        //     return response('You are posting too frequently. Please take a break.', 422);
        // };

        $thread = Thread::findOrFail($threadId);

        $reply = $form->persist($thread);

        // event(new ThreadReceivedNewReply($reply));
        
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

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response('Sorry, your reply could not be saved at this time.', 422);
        }
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
