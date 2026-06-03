<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payout extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'seller_id',
        'amount',
        'note',
        'status',
        'approved_by',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, "approved_by");
    }
    /*===================== End Eloquent Relations ======================*/
}
