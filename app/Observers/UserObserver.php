<?php

namespace App\Observers;

use App\Models\User;
use App\Library\Enum;
use App\Library\Helper;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $difference = Helper::getDifference($user, false, true);

        Helper::createActivityLog('Created', Enum::getUserType($user->user_type), $user->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $difference = Helper::getDifference($user, true);

        Helper::createActivityLog('Updated', Enum::getUserType($user->user_type), $user->id, $difference, request()->ip(), request()->userAgent(), request()->note, request()->status);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $difference = Helper::getDifference($user);

        Helper::createActivityLog('Deleted', Enum::getUserType($user->user_type), $user->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        $difference = Helper::getDifference($user);

        Helper::createActivityLog('Restored', Enum::getUserType($user->user_type), $user->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        $difference = Helper::getDifference($user);

        Helper::createActivityLog('Force Deleted', Enum::getUserType($user->user_type), $user->id, $difference, request()->ip(), request()->userAgent());
    }
}
