<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\Http\Requests\ThreadRequest;
use App\Notifications\ThreadWasUpdated;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    protected function getThreads($channel, $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        };

        return $threads->paginate(20);
    }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(ThreadRequest $request)
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        
        if (request()->wantsJson()) {
            return response($thread, 201);
        }

        // $thread->subscriptions->filter(function ($sub) use ($reply) {
        //     return $sub->user_id != $reply->user_id;
        // })
        // ->each(function ($sub) use ($reply) {
        //     $sub->user->notify(new ThreadWasUpdated($this, $reply));
        // });






        // $thread->subscriptions->filter(function ($sub) use ($reply) {
        //     return $sub->user_id != $reply->user_id;
        // })
        // ->each->notify($reply);






        

        // foreach ($thread->subscriptions as $subscription) {
        //     if ($subscription->user_id != $reply->user_id) {
        //         $subscription->user->notify(new ThreadWasUpdated($this, $reply));
        //     }
        // }

        return redirect()->route('threads')->with('flash', 'Thread created successfully!');
    }

    public function show($channelId, Thread $thread)
    {
        // $key = sprintf("users.%s.visits.%s", auth()->id(), $thread->id);

        // cache()->forever($key, Carbon::now());

        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        return view('threads.show', compact('channelId', 'thread'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update(Request $request, Thread $thread)
    {
        //
    }

    public function destroy($channel, Thread $thread)
    {
        // $thread->replies()->delete();
        $thread->delete();

        return redirect()->route('threads')->with('success', 'Thread Deleted Successfully');
    }
}
