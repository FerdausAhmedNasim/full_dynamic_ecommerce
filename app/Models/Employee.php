<?php

namespace App\Models;

use App\Library\Enum;
use App\Library\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    use HasPermissionsTrait;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'operator_id',
        'job_title',
        'employment_type',
        'entitlement_to_work',
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get all of the user's attachments.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /*=====================Helper Methods======================*/

    public static function getAll()
    {
        return self::all();
    }

    public function getProfileImage(): string
    {
        $path = public_path($this->profile_image);

        if ($this->profile_image && is_file($path) && file_exists($path)) {
            return asset($this->profile_image);
        }

        return Vite::asset(Enum::NO_AVATAR_PATH);
    }


    public static function getAuthProfileImage()
    {
        $employee = User::getAuthUser()->employee;

        if ($employee) {
            $path = public_path($employee->profile_image);

            if ($employee->profile_image && is_file($path) && file_exists($path)) {
                return asset($employee->profile_image);
            }
        }

        return Vite::asset(Enum::NO_AVATAR_PATH);
    }

    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;
        $address .= ', ' . $this->state;
        $address .= ', ' . $this->city;
        $address .= ', ' . $this->state;
        $address .= ', ' . $this->post_code;
        $address .= ', ' . Helper::getCountryName($this->country);

        return $address;
    }

    public static function getAdminByStatus(int $status)
    {
        return User::whereHas('employee')->with('employee')
            ->where('user_type', Enum::USER_TYPE_ADMIN)
            ->where('status', $status)
            ->get();
    }

    public static function getEmployeeByStatus(int $status)
    {
        return User::whereHas('employee')->with('employee')
            ->whereNot('id', 1)
            ->whereIn('user_type', [Enum::USER_TYPE_ADMIN, Enum::USER_TYPE_EMPLOYEE])
            ->where('status', $status)
            ->get();
    }
}
