<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachment',
        'attachable_id',
        'attachable_type',
        'mime_type',
        'for',
        'operator_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent attachable model (user or prescription or referral).
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getAttachment(): string
    {
        $path = public_path($this->attachment);

        if($this->attachment && is_file($path) && file_exists($path)) {
            if(!$this->isImage()) {
                return Vite::asset(Enum::FILE_ICON);
            } else {
                return asset($this->attachment);
            }
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function isImage(): string
    {
        if(str_contains($this->attachment, '.jpg')
        || str_contains($this->attachment, '.jpeg')
        || str_contains($this->attachment, '.svg')
        || str_contains($this->attachment, '.webp')
        || str_contains($this->attachment, '.png')) {
            return true;
        }

        return false;
    }
}
