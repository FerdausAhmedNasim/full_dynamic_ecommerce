<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'seller_id',
        'operator_id',
        'coupon_id',
        'quantity',
        'sub_total_amount',
        'total_amount',
        'discount_amount',
        'return_amount',
        'shipping_cost',
        'order_status',
        'payment_status',
        'payment_type',
        'payment_date',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function store(): HasOne
    {
        return $this->hasOne(Store::class, 'seller_id', 'seller_id');
    }

    public function seller(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function sellerOrderDetails(): HasMany
    {
        return $this->hasMany(SellerOrderDetails::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function return(): HasOne
    {
        return $this->hasOne(OrderReturn::class);
    }

    public function blackUser(): BelongsTo
    {
        return $this->belongsTo(BlackUser::class, 'id', 'seller_order_id');
    }

    /*===================== End Eloquent Relations ======================*/


    public static function getSellerTotalOrderByDate($from, $to)
    {
        return self::where('seller_id', authSellerId())->whereBetween('created_at', [$from, $to]);
    }

    public static function totalCustomersBySeller($from, $to)
    {
        return self::with('order')
                ->select('seller_id', \DB::raw('COUNT(DISTINCT orders.customer_id) as total_customers'))
                ->join('orders', 'seller_orders.order_id', '=', 'orders.id')
                ->where('seller_orders.seller_id', authSellerId())
                ->whereBetween('seller_orders.created_at', [$from, $to])
                ->groupBy('seller_id')
                ->pluck('total_customers');
    }

    public static function getOrdersByDate($from, $to)
    {
        return self::whereBetween('created_at', [$from, $to])
                    ->whereIn('order_status', [Enum::ORDER_STATUS_TYPE_DELIVERED, Enum::ORDER_STATUS_TYPE_PARTIAL_RETURNED])
                    ->where('payment_status', Enum::ORDER_PAYMENT_STATUS_PAID);
    }
}
