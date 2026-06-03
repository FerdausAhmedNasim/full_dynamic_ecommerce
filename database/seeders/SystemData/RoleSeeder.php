<?php

namespace Database\Seeders\SystemData;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'Database User';
        $role->slug = 'super-admin';
        $role->for = 'employee';
        $role->save();

        $admin_user = User::where('email', config('app.admin_email'))->first();

        if ($admin_user) {
            $admin_user->roles()->attach($role);
        }

        $role = new Role();
        $role->name = 'Package 1';
        $role->slug = 'package-1';
        $role->for = 'seller';
        $role->save();
    }
}
