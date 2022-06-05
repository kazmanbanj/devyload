<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use App\Service\Trending;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\Http\Requests\ThreadRequest;

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

        return $threads->paginate(10);
    }

    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        // use this to delete records in redis
        $trending->reset();

        // $trending = array_map('json_decode', Redis::zrevrange('trending_threads', 0, 4));
        // $trending = $trending->get();

        return view('threads.index', compact('threads', 'trending'));
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

    public function show($channelId, Thread $thread, Trending $trending)
    {
        // $key = sprintf("users.%s.visits.%s", auth()->id(), $thread->id);

        // cache()->forever($key, Carbon::now());

        $user = User::whereId(auth()->user()->id)->first();

        if (auth()->check()) {
            $user->read($thread);
        }

        $trending->push($thread);

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
