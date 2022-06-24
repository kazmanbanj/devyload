<?php

namespace App\Listeners;

use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class SendEmailConfirmationRequest
{
    /**
     * Class constructor.
     */
    // public function __construct(type $ = null)
    // {
    //     $this-> = $;
    // }

    public function handle(Registered $event)
    {
        Mail::to($event->user)->send(new PleaseConfirmYourEmail($event->user));
    }
}
