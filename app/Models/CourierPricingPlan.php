<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourierPricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pickup_location',
        'delivery_location',
        'min_weight',
        'max_weight',
        'price',
        'active',
        'delivery_time',
        'operator_id',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper method
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}