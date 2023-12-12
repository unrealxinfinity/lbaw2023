<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateTagNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $id;
    public $type;
    /**
     * Create a new event instance.
     */
    public function __construct($message,$id,$type)
    {    
    
        $this->id = $id;
        $this->message= $message;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn():array
    {   
        if($this->type == 'World'){
            return ['World'.$this->id];
        }
        else if($this->type=='Project')
        {
            return ['Project'.$this->id];
        }
    }

    public function broadcastAs() {
        return 'TagNotification';
    }
}
