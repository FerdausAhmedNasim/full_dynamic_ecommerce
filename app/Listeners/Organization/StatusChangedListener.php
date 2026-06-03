<?php

namespace App\Listeners\Organization;

use App\Events\Organization\StatusChangedEvent;

class StatusChangedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Organization\StatusChangedEvent  $event
     * @return void
     */
    public function handle(StatusChangedEvent $event)
    {
        //
    }
}
