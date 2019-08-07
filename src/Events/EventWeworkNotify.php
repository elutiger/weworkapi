<?php

namespace Elutiger\Weworkapi\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Elutiger\Weworkapi\Datastructure\Message;
use Log;

class EventWeworkNotify
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notice_data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $notice_data)
    {
      
        $this->notice_data = $notice_data;
        //Log::info(collect($notice_data)->toArray());
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
