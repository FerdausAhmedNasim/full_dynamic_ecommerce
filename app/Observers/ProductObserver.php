<?php

namespace App\Observers;

use App\Library\Helper;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $difference = Helper::getDifference($product, false, true);

        Helper::createActivityLog('Created', 'Product', $product->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $difference = Helper::getDifference($product, true);

        Helper::createActivityLog('Updated', 'Product', $product->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $difference = Helper::getDifference($product);

        Helper::createActivityLog('Deleted', 'Product', $product->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        $difference = Helper::getDifference($product);

        Helper::createActivityLog('Restored', 'Product', $product->id, $difference, request()->ip(), request()->userAgent());
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        $difference = Helper::getDifference($product);

        Helper::createActivityLog('Force Deleted', 'Product', $product->id, $difference, request()->ip(), request()->userAgent());
    }
}
