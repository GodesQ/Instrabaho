<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatTypingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $is_typing;
    public $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($status, $user_id)
    {
        $this->is_typing = $status;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat-typing.' . $this->user_id);
    }

    public function broadcastAs() {
        return 'new-chat-typing';
    }
}
