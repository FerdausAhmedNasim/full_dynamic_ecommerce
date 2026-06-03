<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'shipping_type',
        'shipping_fee',
        'shipping_fee_depend_on_quantity',
        'shipping_fee_depend_on_weight',
        'estimated_shipping_days',
        'viewed',
        'discount',
        'discount_type',
        'discount_start',
        'discount_end',
        'dimension',
    ];
}
