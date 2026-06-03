<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use App\Library\Enum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Vite;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPermissionsTrait;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'google_id',
        'user_type',
        'gender',
        'dob',
        'status',
        'avatar',
        'operator_id',
        'email_verified_at',
        'customer_type',
        'description',
        'address',
        'last_login_at',
        'parent_id',
        'balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $appends = [
        'full_name'
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function member(bool $with_trashed = false)
    {
        if ($with_trashed) {
            return $this->hasOne(Member::class, 'user_id', 'id')->withTrashed()->first();
        }

        return $this->hasOne(Member::class, 'user_id', 'id');
    }

    public function store(bool $with_trashed = false)
    {
        if ($with_trashed) {
            return $this->hasOne(Store::class, 'seller_id', 'id')->withTrashed()->first();
        }

        return $this->hasOne(Store::class, 'seller_id', 'id');
    }

    public function emergency()
    {
        return $this->hasOne(EmergencyContact::class, 'user_id', 'id');
    }

    public function userAddress()
    {
        return $this->hasOne(Address::class, 'user_id', 'id');
    }

    public function operator()
    {
        return $this->belongsTo(self::class, 'operator_id');
    }

    public function employeeBranch()
    {
        return $this->hasOne(EmployeeBranch::class, 'employee_id', 'id');
    }

    public function employeeBranches()
    {
        return $this->hasMany(EmployeeBranch::class, 'employee_id', 'id');
    }

    public function branchManager()
    {
        return $this->hasMany(Branch::class, 'manager_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class, 'seller_id', 'id');
    }

    public function totalSale()
    {
        return $this->orders->sum('total_amount');
    }

    public function totalSaleForSeller()
    {
        return $this->sellerOrders->sum('total_amount');
    }

    public function totalCollection()
    {
        return $this->orders->sum('collected_amount');
    }

    public function totalDue()
    {
        return $this->orders->sum('amount_to_be_collect');
    }

    public function Banks(): HasMany
    {
        return $this->hasMany(BankAccount::class, "seller_id");
    }

    public function Products(): HasMany
    {
        return $this->hasMany(Product::class, "seller_id");
    }

    public function customer(): HasMany
    {
        return $this->hasMany(ProductReview::class, "customer_id");
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class, "user_id")->with('product');
    }

    public function payout(): HasMany
    {
        return $this->hasMany(Payout::class, "seller_id");
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class, "seller_id");
    }

    public function categories(): HasMany
    {
        return $this->hasMany(SellerCategory::class, "seller_id");
    }

    /**
     * Get all of the user's attachments.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }



    /*=====================Helper Methods======================*/
    public function getFullNameAttribute()
    {
        $name = $this->first_name;

        if ($this->m_name) {
            $name .= ' ' . $this->m_name;
        }
        $name .= ' ' . $this->last_name;

        return $name;
    }

    public function getFullAddressAttribute()
    {
        $address = $this->userAddress;
        $fullAddress = 'N/A';

        if ($address) {
            $fullAddress = $address->street_address . ', ' .
                $address->state . ', ' . $address->city . ', ' . $address->post_code;
        }

        return $fullAddress;
    }

    public function getIsAdultAttribute()
    {
        return Carbon::parse($this->dob)->diffInYears(now()) >= 18;
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->diffInYears(now());
    }

    public static function getAuthUser()
    {
        return auth()->user();
    }

    public static function getAll()
    {
        return self::all();
    }

    public function role()
    {
        return $this->roles()->first();
    }

    public function getRole()
    {
        return $this->roles()->get();
    }

    public function isSuperAdmin()
    {
        return $this->user_type == Enum::USER_TYPE_SUPER_ADMIN;
    }

    public function isAdmin()
    {
        return $this->user_type == Enum::USER_TYPE_ADMIN;
    }

    public function isEmployee()
    {
        return $this->user_type == Enum::USER_TYPE_EMPLOYEE;
    }

    public function isCustomer()
    {
        return $this->user_type == Enum::USER_TYPE_CUSTOMER;
    }

    public function isMember()
    {
        return $this->user_type == Enum::USER_TYPE_CUSTOMER;
    }

    // public function isSeller()
    // {
    //     return $this->user_type == Enum::USER_TYPE_SELLER;
    // }

    public static function getAuthUserRole()
    {
        return auth()->user()->roles()->first();
    }

    public static function getUsersByType(string $type)
    {
        return self::where('user_type', $type)->get();
    }


    public function getAvatar(): string
    {
        $path = public_path($this->avatar);

        if ($this->avatar && is_file($path) && file_exists($path)) {
            return asset($this->avatar);
        }

        return Vite::asset(Enum::NO_AVATAR_PATH);
    }

    public function getPhotoId(): string
    {
        $path = public_path($this->photo_id);

        if ($this->photo_id && is_file($path) && file_exists($path)) {
            return asset($this->photo_id);
        }

        return Vite::asset(Enum::NO_IMAGE_PATH);
    }

    public static function getActiveEmployee()
    {
        return self::with('employee')
            ->where('user_type', Enum::USER_TYPE_EMPLOYEE)
            ->where('status', Enum::USER_STATUS_ACTIVE)
            ->get();
    }

    public static function getActiveSellers()
    {
        return self::with('store')
            ->where('user_type', Enum::USER_TYPE_SELLER)
            ->where('status', Enum::USER_STATUS_ACTIVE)
            ->get();
    }

    public function scopeWithoutDatabaseUser($query)
    {
        return $query->whereNot('id', 1);
    }

    public function scopeHasAdminPanelAccess($query)
    {
        return $query->whereIn('user_type', [Enum::USER_TYPE_ADMIN, Enum::USER_TYPE_EMPLOYEE]);
    }

    public static function getActiveAdminEmployeeByStatus(int $status)
    {
        return self::whereHas('employee')->with('employee')
            ->withoutDatabaseUser()
            ->hasAdminPanelAccess()
            ->where('status', $status)
            ->get();
    }

    public static function getActiveAdminEmployeeByTeamId(int $team_id)
    {
        return self::whereHas('employee')->with('employee', 'operator')
            ->withoutDatabaseUser()
            ->hasAdminPanelAccess()
            ->where('team_id', $team_id);
    }



    public static function getVerifiedNominated()
    {
        return self::whereUserType(Enum::USER_TYPE_CUSTOMER)
            ->whereNotNull('email_verified_at')
            ->get();
    }

    public static function getVerifiedSeconded()
    {
        return self::whereUserType(Enum::USER_TYPE_CUSTOMER)
            ->whereNotNull('email_verified_at')
            ->get();
    }

    public static function scopeIsMember($query)
    {
        return $query->where('user_type', Enum::USER_TYPE_CUSTOMER);
    }

    public static function getTotalActiveUserByType($from, $to, $user_type)
    {
        return self::where('user_type', $user_type)
            ->where('status', Enum::USER_STATUS_ACTIVE)
            ->whereBetween('created_at', [$from, $to])
            ->count();
    }

}
