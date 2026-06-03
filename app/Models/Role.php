<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'seller_id', 'for'];

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function hasPermission($slug)
    {
        return (bool) $this->permissions->where('slug', $slug)->count();
    }

    // Custom Functions
    public static function getEmployeeRoles($withoutSuperAdmin = false)
    {
        $roles = self::where('for', 'employee')->get();

        if ($withoutSuperAdmin) {
            $roles = $roles->filter(function($role) {
                return $role->slug != 'super-admin';
            });
        }

        return $roles;
    }

    // Custom Functions
    public static function getSellerRoles()
    {
        return self::where('for', 'seller')->get();
    }
}
