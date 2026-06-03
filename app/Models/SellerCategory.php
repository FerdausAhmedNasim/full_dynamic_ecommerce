<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerCategory extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'category_id', 'operator_id', 'commission_rate'];

    /*===================== Start Eloquent Relations ======================*/
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /*===================== End Eloquent Relations ======================*/

    public static function totalCategoryBySeller($from, $to)
    {
        return self::where('seller_id', authSellerId())->whereBetween('created_at', [$from, $to])->count();
    }
}
