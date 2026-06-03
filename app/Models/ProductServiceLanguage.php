<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductServiceLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_service_id',
        'local',
        'title',
        'sub_title',
    ];

    public function productService()
    {
        return $this->hasOne(ProductService::class, 'product_service_id');
    }
}
