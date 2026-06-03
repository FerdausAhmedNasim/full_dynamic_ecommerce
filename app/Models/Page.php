<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['link','active','operator_id','image'];

    /*===================== Start Eloquent Relations ======================*/

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function languages(): HasMany
    {
        return $this->hasMany(PageLanguage::class, 'page_id', 'id');
    }

    /*===================== End Eloquent Relations ======================*/

    /*================ Start Scope Variables ==================*/

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /*================ End Scope Variables ==================*/

    /*================ Helper Function ==================*/

    public function getTranslation($field, $lang = 'en')
    {
        return $this->languages->where('local', $lang)->first()->$field;
    }

    public function getImage(): string
    {
        $path = public_path($this->image);

        if ($this->image && is_file($path) && file_exists($path)) {
            return asset($this->image);
        }

        return Vite::asset(Enum::NO_AVATAR_PATH);
    }

    /*================ End Helper Function ==============*/
}
