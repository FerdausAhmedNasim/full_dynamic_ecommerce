<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductService extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'active',
        'product_id',
        'operator_id',
    ];


    public function productStock()
    {
        return $this->hasOne(Product::class, 'product_id');
    }

    public function productServiceLanguages()
    {
        return $this->hasMany(ProductServiceLanguage::class, 'product_service_id');
    }

    // Helper Methods
    public function getTranslation($field, $lang = 'en')
    {
        return $this->load('productServiceLanguages')?->productServiceLanguages?->where('local', $lang)?->first()?->$field ?? 'N/A';
    }
}
