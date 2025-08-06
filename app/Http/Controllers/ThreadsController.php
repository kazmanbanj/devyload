<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilter;
use App\Http\Requests\ThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Models\Channel;
use App\Models\Thread;
use App\Service\Trending;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadFilter $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }

    protected function getThreads($channel, $filters)
    {
        $threads = Thread::query()->latest()->filter($filters);

        if ($channel->exists) {
            $threads = $channel->threads();
        }

        return $threads->paginate(10);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(ThreadRequest $request)
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => $request['channel_id'],
            'subject' => $request['subject'],
            'body' => $request['body'],
            'slug' => $request['subject'],
        ]);

        if (request()->wantsJson()) {
            return response($thread, 201);
        }
        $request->session()->put('key', 'value');

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');
    }

    public function show(Channel $channel, Thread $thread, Trending $trending)
    {
        if (\Auth::check()) {
            \Auth::user()->seen($thread);
        }

        $thread->visits()->record();

        $trending->push($thread);

        return view('threads/show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update($channel, UpdateThreadRequest $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $request = $request->validated();

        $thread->update($request);
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        return redirect()->route('threads.index')->with('success', 'Thread Deleted Successfully');
    }
}
