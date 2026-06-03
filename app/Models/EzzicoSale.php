<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EzzicoSale extends Model
{
    use HasFactory;

    protected $fillable = [
        "operator_id",
        "product_id",
        "start_date",
        "end_date",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
