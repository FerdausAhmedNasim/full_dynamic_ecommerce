<?php

namespace App\Listeners\Notification;

use App\Events\Notification\CreateEvent;

class CreateListener
{
    public function __construct()
    {
        //
    }

    public function handle(CreateEvent $event)
    {
        $data = $event->notification;
        //Get Notification All Data
    }
}
