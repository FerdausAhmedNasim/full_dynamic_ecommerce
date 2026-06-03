<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'street_address',
        'thana_id',
        'area_id',
        'area_text',
        'note',
        'post_code',
        'latitude',
        'longitude',
        'primary',
        'location',
    ];


    /*===================== Start Eloquent Relations ======================*/
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function thana(): BelongsTo
    {
        return $this->belongsTo(Thana::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*==================== Scope Functions =========================*/
    public function scopePrimary($query)
    {
        return $query->where('primary', true);
    }

    /*==================== Helper Functions =========================*/
    public function getFullAddressAttribute()
    {
        $fullAddress = '';

        if ($this?->street_address) {
            $fullAddress .= $this?->street_address . ',';
        }
        if ($this?->area) {
            $fullAddress .= $this?->area->en_name. ',';
        }
        if ($this->thana) {
            $fullAddress .= $this?->thana->en_name. ',';
        }
        if ($this->thana?->district) {
            $fullAddress .= $this?->thana?->district->en_name;
        }

        return $fullAddress ?? 'N/A';
    }

    public function getSellerPickupHubAttribute()
    {
        return self::where('user_id', auth()->id())->first();
    }

    // =================== Start Helper Methods =================== //
    public static function determineLocation($data) 
    {
        $location = '';
        $thana = Thana::with('district')->find($data['thana_id']);

        // Check if thana is a suburb
        if ($thana && $thana->suburb) {
            $location = Enum::SUBURBS;
        } else {
            $district = $thana->district;

            if ($district) {
                // Check if district is a suburb
                if ($district->suburb) {
                    $location = Enum::SUBURBS;
                } else {
                    // Check if district name is Dhaka
                    $location = (strtolower($district->en_name) === 'dhaka') ? Enum::INSIDE_DHAKA : Enum::OUTSIDE_DHAKA;
                }
            }
        }

        return $location;
    }
    // =================== End Helper Methods =================== //
}
