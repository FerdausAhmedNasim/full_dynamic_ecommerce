<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attribute_id',
        'value',
        'active',
        'operator_id',
    ];

    /*===================== Start Eloquent Relations ======================*/

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /*===================== Start Helper Methods ======================*/

    public function getSelectedValues(array $ids)
    {
        $path = '';

        if (isset($this->thumbnail) && is_file($path) && file_exists($path)) {
            return asset($this->thumbnail);
        }

        return ;
    }
}
