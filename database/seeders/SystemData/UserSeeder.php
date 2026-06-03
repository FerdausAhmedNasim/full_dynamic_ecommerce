<?php

namespace Database\Seeders\SystemData;

use App\Models\User;
use App\Library\Enum;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
    }

    private function createAdmin()
    {
        $user = new User();
        $user->first_name = "Database";
        $user->last_name = "User";
        $user->email = config('app.admin_email');
        $user->password = bcrypt(config('app.admin_password'));
        $user->user_type = Enum::USER_TYPE_SUPER_ADMIN;
        $user->status = Enum::USER_STATUS_ACTIVE;
        $user->phone = '01800000000';
        $user->gender = 'Male';
        $user->dob = '2000-12-12';
        $user->operator_id = 1;
        $user->save();

        $user = new User();
        $user->first_name = "Seller";
        $user->last_name = "Seller";
        $user->email = 'seller@example.com';
        $user->password = bcrypt('seller@example.com');
        $user->user_type = Enum::USER_TYPE_SELLER;
        $user->status = Enum::USER_STATUS_ACTIVE;
        $user->phone = '01800000001';
        $user->gender = 'Male';
        $user->dob = '2000-12-12';
        $user->operator_id = 1;
        $user->save();
    }
}
