<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectMessageEvent implements ShouldBroadCast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $chat;
    // public $session_id;
    // /**
    //  * Create a new event instance.
    //  *
    //  * @return void
    //  */
    // public function __construct($message, $session_id)
    // {
    //     $this->chat = $message;
    //     $this->session_id = $session_id;
    // }

    // /**
    //  * Get the channels the event should broadcast on.
    //  *
    //  * @return \Illuminate\Broadcasting\Channel|array
    //  */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('project-chats.' .  $this->session_id);
    // }

    // public function broadcastAs()
    // {
    //     return 'new-project-chats';
    // }
}
