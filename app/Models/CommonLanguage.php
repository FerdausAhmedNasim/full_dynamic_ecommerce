<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommonLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'local',
        'meta_title',
        'meta_description',
        'languageable_id',
        'languageable_type',
    ];

    public function languageable(): MorphTo
    {
        return $this->morphTo();
    }
}
