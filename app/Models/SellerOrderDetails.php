<?php

namespace App\Models;

use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerOrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_order_id',
        'product_id',
        'stock_variant_id',
        'quantity',
        'return_quantity',
        'product_price',
        'sale_price',
        'discount_type',
        'discount',
        'shipping_cost',
    ];

    public function sellerOrder(): BelongsTo
    {
        return $this->belongsTo(SellerOrder::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productStock(): BelongsTo
    {
        return $this->belongsTo(ProductStock::class, 'stock_variant_id');
    }

    public function productLanguage(): HasOne
    {
        return $this->hasOne(ProductLanguage::class, 'product_id', 'product_id');
    }

    public function getSubTotal($productTotalAmount)
    {
        $totalAmount = 0;

        return $totalAmount += $productTotalAmount;
    }
}
