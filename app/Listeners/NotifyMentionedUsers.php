<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Models\User;
use App\Notifications\YouWereMentioned;
use Illuminate\Support\Facades\Notification;

class NotifyMentionedUsers
{
    public function handle(ThreadReceivedNewReply $event)
    {
        $users = User::whereIn('name', $event->reply->mentionedUsers())->get();
        Notification::send($users, new YouWereMentioned($event->reply));
    }
}
