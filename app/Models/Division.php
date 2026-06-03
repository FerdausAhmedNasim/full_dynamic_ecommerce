<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_name',
        'bn_name',
        'active',
        'created_by',
        'updated_by',
    ];


    /*===================== Start Eloquent Relations ======================*/

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*==================== Scope Functions =========================*/
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
