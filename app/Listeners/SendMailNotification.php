<?php

namespace App\Listeners;

use App\Events\NormalMailFireEvent;
use Illuminate\Support\Facades\Mail;

class SendMailNotification
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
     * @param  NormalMailFireEvent  $event
     * @return void
     */
    public function handle(NormalMailFireEvent $event)
    {
        $tempData=$event->eventData;
        Mail::send('emails.event_email', ['name' => $tempData->name], function ($message)use ($tempData) {
            $message->to($tempData->email)->subject('Event listener checking with email');
        });
    }
}
