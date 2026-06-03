<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'amount',
        'start_date',
        'end_date',
        'is_active',
        'operator_id',
    ];


    /*===================== Start Eloquent Relations ======================*/

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public static function getActiveDiscount()
    {
        return self::with('operator')->where('is_active', true)->whereDate('start_date', '<=', today())->whereDate('end_date', '>=', today())->get();
    }
}
