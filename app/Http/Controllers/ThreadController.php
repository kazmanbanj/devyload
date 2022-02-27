<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\Http\Requests\ThreadRequest;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // private function getThreads(Channel $channel)
    // {
    //     if ($channel->exists) {
    //         $threads = $channel->threads()->latest();
    //     } else {
    //         $threads = Thread::latest();
    //     };

    //     if ($username = request('by')) {
    //         $user = User::where('name', $username)->firstOrFail();

    //         $threads->where('user_id', $user->id);
    //     }

    //     return $threads->paginate(10);
    // }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        if ($channel->exists) {
            $threads = $channel->threads()->latest();
        } else {
            $threads = Thread::latest();
        };

        // $threads = $this->getThreads($channel);
        $threads = $threads->filter($filters)->paginate(10);

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

        return redirect()->route('threads')->with('success', 'Thread created successfully!');
    }

    public function show($channelId, Thread $thread)
    {
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

    public function destroy(Thread $thread)
    {
        //
    }
}
