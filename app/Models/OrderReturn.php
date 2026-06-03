<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'seller_order_id',
        'payment_method',
        'sub_total_amount',
        'coupon_discount',
        'total_amount',
        'payment_transaction_id',
        'note',
        'status',
        'operator_id',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sellerOrder(): BelongsTo
    {
        return $this->belongsTo(SellerOrder::class);
    }

    public function returnDetails()
    {
        return $this->hasMany(ReturnDetails::class, 'return_id', 'id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /*================ Helper Function ==================*/
    public function statusHtml()
    {
        $statusClassMapping = [
            Enum::RETURN_STATUS_PENDING   => 'badge-warning',
            Enum::RETURN_STATUS_APPROVED  => 'badge-success',
            Enum::RETURN_STATUS_REJECTED  => 'badge-danger',
            Enum::RETURN_STATUS_PROCESSED => 'badge-info',
        ];
        $class = $statusClassMapping[$this->status] ?? 'badge-secondary';
        $statusText = Enum::getReturnStatusType($this->status);

        return '<div class="badge ' . $class . '">' . $statusText . '</div>';
    }

    public static function getTotalOrderReturnByDate($from, $to)
    {
        $query = self::where('status', Enum::RETURN_STATUS_APPROVED)->whereBetween('order_returns.created_at', [$from, $to]);
        return $query;
        // if (auth()->user()->user_type == Enum::USER_TYPE_SELLER || auth()->user()->user_type == Enum::USER_TYPE_MODERATOR) {
        //     $query->join('seller_orders', 'order_returns.seller_order_id', '=', 'seller_orders.id')
        //     ->where('seller_orders.seller_id', authSellerId());
        // } elseif (auth()->user()->user_type != Enum::USER_TYPE_SELLER || auth()->user()->user_type != Enum::USER_TYPE_CUSTOMER) {
        //     $query;
        // }

        // return $query->sum('order_returns.total_amount');
    }
}
