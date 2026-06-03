<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'facebook',
        'google',
        'twitter',
        'instagram',
        'youtube',
        'slug',
        'license_no',
        'rating_count',
        'reviews_count',
        'active',
        'seller_id',
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/

    public function seller()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function storeLanguage()
    {
        return $this->hasMany(StoreLanguage::class, 'store_id', 'id');
    }

    public function storeLanguages()
    {
        return $this->hasMany(StoreLanguage::class, 'store_id');
    }

    /*=====================End Eloquent Relations======================*/

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getThumbnailAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first()?->attachment;
    }

    public function getBannerAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_BANNER)->first()?->attachment;
    }


    /*================ Helper Function ==================*/

    public function getThumbnailImage(): string
    {
        $path = public_path(isset($this->thumbnail) ? $this->thumbnail : '');

        if (isset($this->thumbnail) && is_file($path) && file_exists($path)) {
            return asset($this->thumbnail);
        }

        return Vite::asset(Enum::DEFAULT_CATEGORY_IMAGE_PATH);
    }


    public function getBannerImage(): string
    {
        $path = public_path(isset($this->banner) ? $this->banner : '');

        if (isset($this->banner) && is_file($path) && file_exists($path)) {
            return asset($this->banner);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function getTranslation($field, $lang = 'en')
    {
        return $this->load('storeLanguages')->storeLanguages->where('local', $lang)->first()->$field;
    }
}
