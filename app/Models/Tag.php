<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color_code',
        'active',
        'operator_id',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /*===================== End Eloquent Relations ======================*/

    /*================ Start Scope Variables ==================*/
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    /*================ End Scope Variables ==================*/
}
