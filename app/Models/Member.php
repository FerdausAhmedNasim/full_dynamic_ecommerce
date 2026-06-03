<?php

namespace App\Models;

use App\Library\Enum;
use App\Library\Helper;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'subscription_id',
        'user_id',
        'operator_id',
        'nominated_by',
        'seconded_by',
        'age_group',
        'description',
        'is_nominated',
        'is_seconded',
        'nominated_at',
        'seconded_at',
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function nominated()
    {
        return $this->hasOne(User::class, 'id', 'nominated_by');
    }

    public function seconded()
    {
        return $this->hasOne(User::class, 'id', 'seconded_by');
    }

    /**
     * Get all of the user's attachments.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /*=====================Helper Methods======================*/

    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;
        $address .= ', ' . $this->suburb;
        $address .= ', ' . $this->city;
        $address .= ', ' . $this->state;
        $address .= ', ' . $this->post_code;
        $address .= ', ' . Helper::getCountryName($this->country);

        return $address;
    }

    public function getProfileImage(): string
    {
        $path = public_path($this->profile_image);

        if($this->profile_image && is_file($path) && file_exists($path)) {
            return asset($this->profile_image);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public function getNIDImage(): string
    {
        $path = public_path($this->photo_id);

        if($this->photo_id && is_file($path) && file_exists($path)) {
            return asset($this->photo_id);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public static function getMembersByStatus(int $status)
    {
        return User::whereHas('member')->with('member')
            ->where('user_type', Enum::USER_TYPE_CUSTOMER)
            ->where('status', $status)
            ->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function scopeIsNominated($query)
    {
        return $query->where('is_nominated', true);
    }

    public function scopeIsSeconded($query)
    {
        return $query->where('is_seconded', true);
    }

    public static function scopeNominatedAt($query)
    {
        return $query->whereNotNull('nominated_at');
    }

    public function scopeSecondedAt($query)
    {
        return $query->whereNotNull('seconded_at');
    }
}
