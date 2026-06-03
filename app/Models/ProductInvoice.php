<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'seller_id',
        'sub_total_amount',
        'vat_amount',
        'discount_amount',
        'due_amount',
        'return_amount',
        'packaging_cost',
        'delivery_cost',
        'other_cost',
        'total_amount',
        'payment_status',
        'discount',
        'discount_type',
        'discount_start',
        'discount_end',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /*===================== End Eloquent Relations ======================*/
}
