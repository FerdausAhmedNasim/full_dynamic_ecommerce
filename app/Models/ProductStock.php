<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_ids',
        'name',
        'sku',
        'current_stock',
        'unit_price',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
    /*===================== End Eloquent Relations ======================*/

    public function getVariantImageAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_VARIANT)->first()?->attachment;
    }


    protected $appends = ['product_variant_image'];

    public function getProductVariantImageAttribute()
    {
        $path = public_path(isset($this->variant_image) ? $this->variant_image : '');

        if (isset($this->variant_image) && is_file($path) && file_exists($path)) {
            return asset($this->variant_image);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function getDiscountedPriceAttribute()
    {
        $product = $this->load('product')->product;

        if ($product->has_variant) {
            $price = $this->unit_price;
            $discount = $product->productDetails->discount;
            $discount_type = $product->productDetails->discount_type;

            if (isset($discount_type)) {
                if ($discount_type && $discount_type == Enum::DISCOUNT_TYPE_FLAT) {
                    $price = $price - $discount;
                } else {
                    $price = $price - (($price / 100) * $discount);
                }
            }

            return $price;
        }

        return $product->unit_price;
    }

    /*===================== Start Helper Methods ======================*/

    public function getVariantImage(): string
    {
        $path = public_path(isset($this->variant_image) ? $this->variant_image : '');

        if (isset($this->variant_image) && is_file($path) && file_exists($path)) {
            return asset($this->variant_image);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function getPriceAfterDiscount(bool $forDetailsPageVariant = false)
    {
        $price = $this->unit_price;
        $discount = $this->load('product')->product->productDetails->discount;
        $discount_type = $this->load('product')->product->productDetails->discount_type;

        if (isset($discount_type)) {
            if ($discount_type && $discount_type == Enum::DISCOUNT_TYPE_FLAT) {
                $price = $price - $discount;
            } else {
                $price = $price - (($price / 100) * $discount);
            }
        }

       $ezzicoDiscount = $this->product->getEzzicoDiscount($this->unit_price);

       if ($forDetailsPageVariant && $ezzicoDiscount) {
           return $price - $ezzicoDiscount;
       }

       return $price;
    }

    public function getDiscountInfo(): string
    {
        $this->load('product');

        $ezzicoDiscountFlat = $this->product->getEzzicoDiscount($this->unit_price);
        $ezzicoDiscountPercentage = $ezzicoDiscountFlat > 0 ? $this->product->sellerCategory(parentCategory($this->product->category_id)->id, $this->product->seller_id)?->commission_rate : 0;

        $discount = '';

        if ($this->product->has_discount) {
            $discount = $this->product->productDetails->discount;
            $discount_type = $this->product->productDetails->discount_type;

            if (isset($discount_type)) {
                if ($discount_type && $discount_type == Enum::DISCOUNT_TYPE_FLAT) {
                    $discount = (settings('currency_symbol') ? settings('currency_symbol') : '$') . $this->product->productDetails->discount + $ezzicoDiscountFlat . ' Off';
                } else {
                    $discount = ($discount + $ezzicoDiscountPercentage) . '% Off';
                }
            }
        } else {
            $discount = $ezzicoDiscountPercentage . '% Off';
        }

        return $discount;
    }
}
