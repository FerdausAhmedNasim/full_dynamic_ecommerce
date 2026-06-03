<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable =[
        'bank_name',
        'branch_name',
        'account_name',
        'account_number',
        'routing_number',
        'swift_code',
        'seller_id',
    ];

    public function getBanks() {
        return $this->belongsTo(User::class, "seller_id");
    }

}
