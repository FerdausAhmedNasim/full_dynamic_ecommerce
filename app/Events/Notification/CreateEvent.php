<?php

namespace App\Events\Notification;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
