<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['order', 'link', 'active', 'operator_id'];


    /*================== Eloquent Relationship =======================*/
    public function operator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'operator_id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getBackgroundAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_BACKGROUND)->first()?->attachment;
    }

    /*================ End Eloquent Relationship =====================*/

    /*==================== Scope Functions =========================*/
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    /*================== End Scope Functions =======================*/

    /*==================== Helper Functions =========================*/

    public function getBackgroundImage(): string
    {
        $path = public_path(isset($this->background) ? $this->background : '');

        if (isset($this->background) && is_file($path) && file_exists($path)) {
            return asset($this->background);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }
    /*================== End Helper Functions =======================*/
}
