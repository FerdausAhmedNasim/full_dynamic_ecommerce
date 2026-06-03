<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvertiseLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'amount',
        'operator_id',
        'active',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function getLocationNameAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->location));
    }
}
