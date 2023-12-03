<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BingoValueSubmitEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $channel;
    public $submitValue;

    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
        $this->channel = $data[config('broadcasting.game.channel')];
        $this->submitValue = $data[config('broadcasting.game.submitValue')];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel($this->channel),
        ];
    }

    public function broadcastWith()
    {
        return [
            config('broadcasting.game.submitValue') => $this->submitValue,
        ];
    }
}
