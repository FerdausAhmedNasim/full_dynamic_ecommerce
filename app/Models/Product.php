<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'slug',
        'type',
        'unit',
        'unit_price',
        'weight',
        'barcode',
        'has_variant',
        'attribute_sets',
        'selected_variants',
        'selected_variants_ids',
        'current_stock',
        'minimum_order_quantity',
        'stock_notification',
        'low_stock_to_notify',
        'stock_visibility',
        'total_sale',
        'status',
        'purchase_price',
        'approved',
        'featured',
        'refundable',
        'show_home_page',
        'rating',
        'has_product_base_shipping',
        'has_discount',
        'seller_id',
        'cash_on_delivery',
        'operator_id',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function productLanguages()
    {
        return $this->hasMany(ProductLanguage::class, 'product_id');
    }

    public function productDetails()
    {
        return $this->hasOne(ProductDetails::class, 'product_id');
    }

    public function productStock()
    {
        return $this->hasOne(ProductStock::class, 'product_id');
    }

    public function productStocks()
    {
        return $this->hasMany(ProductStock::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductStock::class, 'product_id')->whereNotNull('variant_ids');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function productReview(bool $only_active = false): HasMany
    {
        if ($only_active) {
            return $this->hasMany(ProductReview::class, 'product_id')->where('active', true)->with('customer', 'attachments');
        }

        return $this->hasMany(ProductReview::class, 'product_id')->with('customer', 'attachments');
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class, "product_id");
    }

    public function sellerOrderDetails()
    {
        return $this->hasMany(SellerOrderDetails::class, 'product_id');
    }

    public function ezzicoDiscounts()
    {
        return $this->hasMany(EzzicoSale::class, 'product_id');
    }

    public function ezzicoDiscount()
    {
        return $this->hasOne(EzzicoSale::class, 'product_id');
    }

    public function activeEzzicoDiscount()
    {
        $currentDate = now()->toDateString();

        return $this->hasOne(EzzicoSale::class, 'product_id')
                    ->where('start_date', '<=', $currentDate)
                    ->where('end_date', '>=', $currentDate);
    }

    public function question()
    {
        return $this->hasMany(ProductQuestion::class, 'product_id');
    }

    public function productServices()
    {
        return $this->hasMany(ProductService::class, 'product_id');
    }

    /*===================== End Eloquent Relations ======================*/

    protected $appends = ['thumbnail', 'product_thumbnail', 'price_after_discount'];

    public function getThumbnailAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first()?->attachment;
    }

    public function getGalleryImagesAttribute()
    {
        return $this->morphMany(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_GALLERY)->get();
    }

    public function getDescriptionAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_DESCRIPTION)->first()?->attachment;
    }

    public function getMetaImageAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_META)->first()?->attachment;
    }


    public function getProductThumbnail()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first();
    }

    public function getProductDescriptionImage()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_DESCRIPTION)->first();
    }

    public function getProductMetaImageAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_META)->first();
    }

    public function getPriceAfterDiscountAttribute() 
    {
        return $this->getPriceAfterDiscount();
    }

    public function getProductThumbnailAttribute() 
    {
        return $this->getThumbnailImage();
    }


    /*======================== Scope Function =========================*/
    public static function scopeToday($query)
    {
        return $query->where('todays_deal', true);
    }

    public static function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public static function scopeRefundable($query)
    {
        return $query->where('refundable', true);
    }

    public static function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public static function scopePublished($query)
    {
        return $query->where('status', Enum::PRODUCT_STATUS_PUBLISHED);
    }

    public static function scopeShowHomePage($query)
    {
        return $query->where('show_home_page', Enum::PRODUCT_SHOW_HOME_PAGE);
    }
    /*======================== End Scope Function =========================*/

    /*===================== Start Helper Methods ======================*/

    public function getThumbnailImage(): string
    {
        $path = public_path(isset($this->thumbnail) ? $this->thumbnail : '');

        if (isset($this->thumbnail) && is_file($path) && file_exists($path)) {
            return asset($this->thumbnail);
        }

        // return Vite::asset(Enum::NO_IMAGE_PATH);
        return Vite::asset(Enum::DEFAULT_PRODUCT_IMAGE_PATH);
    }

    public function getDescriptionImage(): string
    {
        $path = public_path(isset($this->description) ? $this->description : '');

        if (isset($this->description) && is_file($path) && file_exists($path)) {
            return asset($this->description);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function getMetaImage(): string
    {
        $path = public_path(isset($this->meta_image) ? $this->meta_image : '');

        if (isset($this->meta_image) && is_file($path) && file_exists($path)) {
            return asset($this->meta_image);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function getPriceAfterDiscount()
    {
        $price = $this->unit_price;

        if ($this->has_variant) {
            $price = $this->load('variants')->variants->first()?->unit_price;
        }

        $productDetails = $this->load('productDetails')->productDetails;

        if (isset($productDetails->discount_type)) {
            if ($productDetails->discount_type && $productDetails->discount_type == Enum::DISCOUNT_TYPE_FLAT) {
                $price = $price - $productDetails->discount;
            } else {
                $price = $price - (($price / 100) * $productDetails->discount);
            }
        }

        return $price;
    }

    public function getDiscountInfo(): string
    {
        $discount = '';

        if (isset($this->productDetails->discount_type)) {
            if ($this->productDetails->discount_type && $this->productDetails->discount_type == Enum::DISCOUNT_TYPE_FLAT) {
                $discount = (settings('currency_symbol') ? settings('currency_symbol') : '$') . $this->productDetails->discount . ' Off';
            } else {
                $discount = ($this->productDetails->discount) . '% Off';
            }
        }

        return $discount;
    }

    public function getTranslation($field, $lang = 'en')
    {
        return $this->load('productLanguages')->productLanguages->where('local', $lang)->first()->$field;
    }

    public function getOverallRetting(bool $only_active = false)
    {
        if($only_active) {
            return round($this->productReview(true)->avg('rating'), 1) ?? 0;
        }

        return round($this->productReview->avg('rating'), 1) ?? 0;
    }

    public function getRatingWiseTotalRating(bool $only_active = false)
    {
        $query = ProductReview::where('product_id', $this->id)->select('rating', DB::raw('count(*) as total'));

        if($only_active) {
            $query->where('active', true);
        }

        $data = $query->groupBy('rating')->pluck('total', 'rating')->toArray();

        $total = Enum::getRattingType();

        foreach($total as $key => $value) {
            $total[$key] = $data[$key] ?? 0;
        }

        return $total;
    }

    public function getTotalRetting($field, $lang = 'en')
    {
        return $this->productLanguages->where('local', $lang)->first()->$field;
    }

    public function isBuyThisProduct()
    {
        $productId = $this->id;
        $customerId = auth()->id();
        
        return Order::where('customer_id', $customerId)
            ->whereHas('sellerOrders', function ($query) use ($productId) {
                $query->where('order_status', Enum::ORDER_STATUS_TYPE_DELIVERED)
                    ->whereHas('sellerOrderDetails', function ($query) use ($productId) {
                        $query->where('product_id', $productId);
                    });
            })
            ->exists();
    }
    /*===================== End Helper Methods ======================*/

    public static function getTotalProductByDate($from, $to)
    {
        $query = self::where('approved', true)->whereBetween('created_at', [$from, $to]);
        return $query;
        // if (auth()->user()->user_type == Enum::USER_TYPE_SELLER || auth()->user()->user_type == Enum::USER_TYPE_MODERATOR) {
        //     return $query->where('seller_id', authSellerId());
        // } elseif (auth()->user()->user_type != Enum::USER_TYPE_SELLER || auth()->user()->user_type != Enum::USER_TYPE_CUSTOMER) {
        //     return $query;
        // }
    }


    public function calculatePriceAfterDiscount($price)
    {
        $productDetails = $this->load('productDetails')->productDetails;

        if (isset($productDetails->discount_type)) {
            if ($productDetails->discount_type && $productDetails->discount_type == Enum::DISCOUNT_TYPE_FLAT) {
                $price = $price - $productDetails->discount;
            } else {
                $price = $price - (($price / 100) * $productDetails->discount);
            }
        }

        return $price;
    }

    public function getEzzicoDiscount($product_price)
    {
        $currentDate = now();

        $productsWithDiscount = Product::where('id', $this->id)
            ->with(['ezzicoDiscounts' => function ($query) use ($currentDate) {
                $query->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate);
            }])
            ->first();

        $hasDiscount = $productsWithDiscount->ezzicoDiscounts->isNotEmpty();

        $discount = 0;

        if ($hasDiscount) {
            $discount = ($product_price / 100) * $this->sellerCategory(parentCategory($this->category_id)->id, $this->seller_id)?->commission_rate;
        }

        return $discount;
    }
}
