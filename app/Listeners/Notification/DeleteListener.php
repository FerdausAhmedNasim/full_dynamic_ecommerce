<?php

namespace App\Listeners\Notification;

use App\Events\Notification\DeleteEvent;

class DeleteListener
{
    public function __construct()
    {
        //
    }

    public function handle(DeleteEvent $event)
    {
        $data = $event->notification;
        //get all delected notification data
    }
}
