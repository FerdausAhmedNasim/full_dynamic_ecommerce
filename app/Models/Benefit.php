<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Benefit extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'sub_title', 'order', 'active', 'operator_id'];


    /*================== Eloquent Relationship =======================*/
    public function operator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'operator_id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    
    public function getImageAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_ICON)->first()?->attachment;
    }
    /*================ End Eloquent Relationship =====================*/

    /*==================== Scope Functions =========================*/
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    /*================== End Scope Functions =======================*/

    /*==================== Helper Functions =========================*/

    public function getImage(): string
    {
        $path = public_path(isset($this->image) ? $this->image : '');

        if (isset($this->image) && is_file($path) && file_exists($path)) {
            return asset($this->image);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }
    /*================== End Helper Functions =======================*/
}
