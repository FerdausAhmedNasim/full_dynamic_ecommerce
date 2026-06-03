<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'active',
        'rating',
        'comment',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function customer()
    {
        return $this->belongsTo(User::class, "customer_id");
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
