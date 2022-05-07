<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        // $mentionedUsers = $event->reply->mentionedUsers();
        // foreach ($mentionedUsers as $name) {
        //     $user = User::whereName($name)->first();

        //     if ($user) {
        //         $user->notify(new YouWereMentioned($event->reply));
        //     }
        // } or

        collect($event->reply->mentionedUsers())
            ->map(function ($name) {
                return User::whereName($name)->first();
            })
            ->filter()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
