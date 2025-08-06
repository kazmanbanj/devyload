<?php

namespace App\Providers;

use App\Events\ThreadReceivedNewReply;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\NotifySubscribers;
use App\Listeners\SendEmailConfirmationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ThreadReceivedNewReply::class => [
            NotifyMentionedUsers::class,
            NotifySubscribers::class,
        ],
        // Registered::class => [
        //     SendEmailConfirmationRequest::class,
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
