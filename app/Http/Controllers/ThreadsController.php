<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
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

        return redirect()->route('threads')->with('flash', 'Thread created successfully!');
    }

    public function show($channelId, Thread $thread)
    {
        $replies = $thread->replies()->paginate(5);

        return view('threads.show', compact('channelId', 'thread', 'replies'));
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
