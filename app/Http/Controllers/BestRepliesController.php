<?php

namespace App\Http\Controllers;

use App\Models\Reply;

class BestRepliesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Reply $reply)
    {
        // $this->authorize('update', $reply->thread);

        $reply->thread->markBestReply($reply);
    }
}
