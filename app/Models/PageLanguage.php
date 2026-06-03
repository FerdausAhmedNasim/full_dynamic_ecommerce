<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'local',
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'page_id',
    ];

    /*===================== Start Eloquent Relations ======================*/

    public function page(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /*===================== End Eloquent Relations ======================*/

    /*================ Start Scope Variables ==================*/

    /*================ End Scope Variables ==================*/

    /*================ Helper Function ==================*/

    /*================ End Helper Function ==============*/
}
