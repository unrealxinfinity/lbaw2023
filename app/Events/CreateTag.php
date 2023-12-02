<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateTag implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $project_id;
    /**
     * Create a new event instance.
     */
    public function __construct($tag_name,$project_id)
    {    
        $this->project_id = $project_id;
        $this->message= "Tag " . $tag_name ." created";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn():array
    {   
        return ['Project'.$this->project_id];
    }

    public function broadcastAs() {
        return 'CreateTag';
    }
}
