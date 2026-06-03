<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductQuestion extends Model
{
    use HasFactory;

    protected $fillable =[
        'comment',
        'customer_id',
        'seller_id',
        'product_id',
        'active',
        'parent_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function customer()
    {
        return $this->belongsTo(User::class, "customer_id");
    }

    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductQuestion::class);
    }

    public function childrenQuestion()
    {
        return $this->hasOne(ProductQuestion::class, 'parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // ======================== Helper Methods ======================== //
    public static function getProductQuestion($product_id)
    {
        return self::with('customer', 'product')->where('product_id', $product_id)->whereNull('parent_id')->get();
    }
}
