<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\Location;

class LocationObserver
{
    /**
     * Handle the Location "created" event.
     *
     * @param  \App\Models\Location  $location
     * @return void
     */
    public function created(Location $location)
    {
        $difference = Helper::getDifference($location, false, true);

        Helper::createActivityLog('Created', 'Location', $location->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Location "updated" event.
     *
     * @param  \App\Models\Location  $location
     * @return void
     */
    public function updated(Location $location)
    {
        $difference = Helper::getDifference($location, true);

        Helper::createActivityLog('Updated', 'Location', $location->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Location "deleted" event.
     *
     * @param  \App\Models\Location  $location
     * @return void
     */
    public function deleted(Location $location)
    {
        $difference = Helper::getDifference($location);

        Helper::createActivityLog('Deleted', 'Location', $location->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Location "restored" event.
     *
     * @param  \App\Models\Location  $location
     * @return void
     */
    public function restored(Location $location)
    {
        $difference = Helper::getDifference($location);

        Helper::createActivityLog('Restored', 'Location', $location->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Location "force deleted" event.
     *
     * @param  \App\Models\Location  $location
     * @return void
     */
    public function forceDeleted(Location $location)
    {
        $difference = Helper::getDifference($location);

        Helper::createActivityLog('Force Deleted', 'Location', $location->id, $difference, request()->ip(), request()->userAgent());
    }
}
