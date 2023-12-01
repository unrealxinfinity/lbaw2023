<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateWorld
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $world_id;
    /**
     * Create a new event instance.
     */
    public function __construct($world_name,$world_id)
    {
        $this->world_id = $world_id;
        $this->message = "World " . $world_name ." created";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            'CreateWorldOn'.$this->world_id,
        ];
    }
    public function broadcastAs() {
        return "worldCreated";
    }
}
