<?php

namespace App\Events;

use Cache;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GartUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $gart;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($gart)
    {
        $this->gart = $gart;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['gart.' . $this->gart->id];
        //return new PrivateChannel('channel-name');
    }

    public function broadcastAs()
    {
        return 'gartUpdated';
    }
}
