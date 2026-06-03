<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'local',
        'title',
        'short_description',
        'description',
        'shipping_note',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'tags',
    ];

    public function getShortTitleAttribute() {
        return Str::limit($this->title, 40);
    }

    public function getMobileShortTitleAttribute() {
        return Str::limit($this->title, 30);
    }

    public function getShortTitleForDashboardAttribute() {
        return Str::limit($this->title, 30);
    }
}
