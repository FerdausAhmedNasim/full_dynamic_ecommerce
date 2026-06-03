<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'parent_id',
        'order',
        'active',
        'featured',
        'operator_id'
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

    public function childrenCategoriesOrderBy()
    {
        return $this->hasMany(Category::class, 'parent_id')
                    ->with('categories')
                    ->orderBy('order');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getThumbnailAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first()?->attachment;
    }

    public function getIconAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_ICON)->first()?->attachment;
    }

    public function languages(): MorphMany
    {
        return $this->morphMany(CommonLanguage::class, 'languageable');
    }
    
    /*===================== End Eloquent Relations ======================*/

    /*================ Start Scope Variables ==================*/
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOnlyParent($query)
    {
        return $query->where('parent_id', null);
    }

    /*================ End Scope Variables ==================*/

    /*================ Helper Function ==================*/

    public function getThumbnailImage(): string
    {
        $path = public_path(isset($this->thumbnail) ? $this->thumbnail : '');

        if (isset($this->thumbnail) && is_file($path) && file_exists($path)) {
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

    public static function getTotalActiveCategory($from, $to)
    {
        return self::active()
            ->whereBetween('created_at', [$from, $to])
            ->count();
    }
}
