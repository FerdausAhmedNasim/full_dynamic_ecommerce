<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'en_name',
        'bn_name',
        'suburb',
        'active',
        'created_by',
        'updated_by',
    ];


    /*===================== Start Eloquent Relations ======================*/
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

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
