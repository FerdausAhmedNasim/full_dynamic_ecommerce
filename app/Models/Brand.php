<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'active',
        'featured',
        'operator_id'
    ];

    /*===================== Start Eloquent Relations ======================*/

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /*===================== End Eloquent Relations ======================*/

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getThumbnailAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first()?->attachment;
    }

    public function languages(): MorphMany
    {
        return $this->morphMany(CommonLanguage::class, 'languageable');
    }

    /*================ Start Scope Variables ==================*/
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
    /*================ End Scope Variables ==================*/

    /*================ Helper Function ==================*/

    public function getThumbnailImage(): string
    {
        $path = public_path($this->getThumbnailAttribute() ?? '');

        if ($this->getThumbnailAttribute() && is_file($path) && file_exists($path)) {
            return asset($this->thumbnail);
        }

        return Vite::asset(Enum::DEFAULT_CATEGORY_IMAGE_PATH);
    }


    public function getIconImage(): string
    {
        $path = public_path(isset($this->icon) ? $this->icon : '');

        if (isset($this->icon) && is_file($path) && file_exists($path)) {
            return asset($this->icon);
        }

        return Vite::asset(Enum::DEFAULT_CATEGORY_IMAGE_PATH);
    }

    public function getTranslation($field, $lang = 'en')
    {
        return $this->load('languages')->languages->where('local', $lang)->first()->$field;
    }
    /*================ End Helper Function ==============*/

    public static function getTotalActiveBrand($from, $to)
    {
        return self::active()
            ->whereBetween('created_at', [$from, $to])
            ->count();
    }
}
