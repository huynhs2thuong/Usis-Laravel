<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MemberUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $alert;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['gart.' . $this->alert->gartId];
        //return new PrivateChannel('channel-name');
    }

    public function broadcastAs()
    {
        return 'memberUpdated';
    }
}
