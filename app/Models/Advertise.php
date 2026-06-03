<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertise extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'link',
        'product_ids',
        'status',
        'payment_status',
        'start_date',
        'end_date',
        'seller_id',
        'advertise_location_id',
        'note',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function adLocation()
    {
        return $this->belongsTo(AdvertiseLocation::class, 'advertise_location_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
    /*===================== End Eloquent Relations ======================*/

    protected $appends = ['image'];

    /*================ Helper Function ==================*/
    public function getImageAttribute()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('for', Enum::ATTACHMENT_TYPE_THUMBNAIL)->first()?->attachment;
    }

    public function getImage(): string
    {
        $path = public_path(isset($this->image) ? $this->image : '');

        if (isset($this->image) && is_file($path) && file_exists($path)) {
            return asset($this->image);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public static function getFlashSaleProductIds()
    {
        $ids = [];

        return self::with('adLocation')
        ->where('status', Enum::AD_STATUS_ACTIVE)
        ->whereHas('adLocation', function ($q) {
            $q->where('location', Enum::AD_LOCATION_FLASH_SALE);

        })
        ->where(function ($query) {
            $query->whereDate('start_date', '<=', now()->toDateString())
            ->whereDate('end_date', '>=', now()->toDateString());
        })
        ->pluck('product_ids')->flatMap(function ($values) use ($ids) {
            return array_merge(json_decode($values), $ids);
        })
        ->all();
    }

    public static function getTopSaleProductIds()
    {
        $ids = [];

        return self::with('adLocation')
        ->where('status', Enum::AD_STATUS_ACTIVE)
        ->whereHas('adLocation', function ($q) {
            $q->where('location', Enum::AD_LOCATION_TOP_SALE);

        })
        ->where(function ($query) {
            $query->whereDate('start_date', '<=', now()->toDateString())
            ->whereDate('end_date', '>=', now()->toDateString());
        })
        ->pluck('product_ids')->flatMap(function ($values) use ($ids) {
            return array_merge(json_decode($values), $ids);
        })
        ->all();
    }

    public static function getDealYouCanNotMiss()
    {
        return self::with('adLocation')
        ->where('status', Enum::AD_STATUS_ACTIVE)
        ->whereHas('adLocation', function ($q) {
            $q->where('location', Enum::AD_LOCATION_DEAL_YOU_CAN_NOT_MISS);
        })
        ->where(function ($query) {
            $query->whereDate('start_date', '<=', now()->toDateString())
            ->whereDate('end_date', '>=', now()->toDateString());
        })
        ->inRandomOrder()
        ->limit(12)
        ->get();
    }

    public static function getTopBrandOffers()
    {
        return self::with('adLocation')
        ->where('status', Enum::AD_STATUS_ACTIVE)
        ->whereHas('adLocation', function ($q) {
            $q->where('location', Enum::AD_LOCATION_TOP_BRAND_OFFER);
        })->where(function ($query) {
            $query->whereDate('start_date', '<=', now()->toDateString())
            ->whereDate('end_date', '>=', now()->toDateString());
        })
        ->inRandomOrder()
        ->limit(4)
        ->get();
    }
    /*================ End Helper Function ==============*/
}
