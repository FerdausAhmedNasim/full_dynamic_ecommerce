<?php

namespace App\Listeners\Campaign;

use App\Events\Campaign\StatusChangedEvent;

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
     * @param  \App\Events\Campaign\StatusChangedEvent  $event
     * @return void
     */
    public function handle(StatusChangedEvent $event)
    {
        //
    }
}
