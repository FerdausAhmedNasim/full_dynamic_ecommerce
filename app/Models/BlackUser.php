<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlackUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_order_id',
        'shipping_cost',
        'active',
        'penalty_payment_date',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function sellerOrder(): HasOne
    {
        return $this->hasOne(SellerOrder::class);
    }

    /*================ Start Scope Variables ==================*/
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    /*================ End Scope Variables ==================*/

    /*================ Start Helper Methods ==================*/
    public static function getBlackLists()
    {
        return self::active()->where('user_id', auth()->id())->get();
    }
    /*================ End Helper Methods ==================*/
}
