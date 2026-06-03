<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'is_active',
        'manager_id',
        'location_id',
        'operator_id',
    ];

    /*===================== Start Eloquent Relations ======================*/

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manager()
    {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }

    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function branchEmployee()
    {
        return $this->hasMany(EmployeeBranch::class, 'branch_id', 'id');
    }

    public function balance()
    {
        return $this->hasMany(Account::class, 'branch_id', 'id');
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class, 'branch_id', 'id');
    }

    /*===================== End Eloquent Relations ======================*/

    public function isActive()
    {
        return $this->is_active == true;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
