<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $difference = Helper::getDifference($category, false, true);

        Helper::createActivityLog('Created', 'Category', $category->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        $difference = Helper::getDifference($category, true);

        Helper::createActivityLog('Updated', 'Category', $category->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $difference = Helper::getDifference($category);

        Helper::createActivityLog('Deleted', 'Category', $category->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        $difference = Helper::getDifference($category);

        Helper::createActivityLog('Restored', 'Category', $category->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        $difference = Helper::getDifference($category);

        Helper::createActivityLog('Force Deleted', 'Category', $category->id, $difference, request()->ip(), request()->userAgent());
    }
}
