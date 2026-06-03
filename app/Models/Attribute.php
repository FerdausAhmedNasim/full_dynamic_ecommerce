<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
        'operator_id',
    ];

    /*===================== Start Eloquent Relations ======================*/

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }


    /*================ Start Scope Variables ==================*/
    public static function scopeActive()
    {
        return self::where('active', true);
    }
    /*================ End Scope Variables ==================*/
}
