<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use stdClass;

class NormalMailFireEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventData;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user=User::where('id', Auth::user()->id)->first();
        $tempData=new stdClass;
        $tempData->email=$user->email;
        $tempData->name=$user->name;

        $this->eventData=$tempData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
