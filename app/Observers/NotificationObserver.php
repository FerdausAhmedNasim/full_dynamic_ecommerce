<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\Notification;

class NotificationObserver
{
    /**
     * Handle the Notification "created" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function created(Notification $notification)
    {
        $difference = Helper::getDifference($notification, false, true);

        Helper::createActivityLog('Created', 'Notification', $notification->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Notification "updated" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function updated(Notification $notification)
    {
        $difference = Helper::getDifference($notification, true);

        Helper::createActivityLog('Updated', 'Notification', $notification->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Notification "deleted" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function deleted(Notification $notification)
    {
        $difference = Helper::getDifference($notification);

        Helper::createActivityLog('Deleted', 'Notification', $notification->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Notification "restored" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function restored(Notification $notification)
    {
        $difference = Helper::getDifference($notification);

        Helper::createActivityLog('Restored', 'Notification', $notification->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Notification "force deleted" event.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function forceDeleted(Notification $notification)
    {
        $difference = Helper::getDifference($notification);

        Helper::createActivityLog('Force Deleted', 'Notification', $notification->id, $difference, request()->ip(), request()->userAgent());
    }
}
