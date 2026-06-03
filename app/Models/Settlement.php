<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'money_sent',
        'amount',
        'seller_id',
        'status',
        'paid_by',
        'paid_date',
        'total_sale',
        'commission',
        'ad_cost',
        'date',
        'start_date',
        'end_date',
        'due_amount'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, "paid_by");
    }

    public function orders(): HasMany
    {
        return $this->hasMany(SettlementOrder::class);
    }
}
