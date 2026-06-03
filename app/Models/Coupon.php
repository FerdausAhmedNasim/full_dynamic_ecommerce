<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'maximum_discount',
        'start_date',
        'end_date',
        'active',
        'seller_id',
    ];


    // Helper method
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public static function getCoupon()
    {
        return self::where('seller_id', sellerId());
    }
}
