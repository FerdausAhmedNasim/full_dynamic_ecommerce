<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'settlement_id',
        'seller_id',
        'type',
        'amount',
        'dr_cr',
        'transaction_id',
        'payment_method',
        'operator_id',
        'note',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
