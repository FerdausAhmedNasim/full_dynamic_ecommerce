<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_identifier',
        'product_id',
        'variant',
        'quantity',
        'price',
        'ezzico_discount',
    ];

    /*===================== Start Eloquent Relations ======================*/

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /*===================== End Eloquent Relations ======================*/

    // Helper Method

    public static function getTotalAmount($quantity, $unit_price)
    {
        return $quantity * $unit_price;
    }

    public static function getCartSubtotal()
    {
        $cartIdentifier = request()->cookie('cart_identifier');
        $cartItems = self::with('product')->where('cart_identifier', $cartIdentifier)->get();

        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        return $subtotal;
    }
}
