<?php

namespace App\Events;

use App\Models\User;
use App\Models\Convo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Broadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
   
    public $message;
    public $userId;
    public $appointmentId;
    public $created_at;


    public function __construct($message, $userId, $appointmentId, $created_at)
    {
        //
    
        $this->message = $message;
        $this->userId = $userId;
        $this->appointmentId = $appointmentId;
        $this->created_at = $created_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat' . $this->appointmentId);
    
    }

    public function broadcastAs(){
        return 'newchat';
    }



}



