<?php

namespace Database\Seeders\DemoData;

use App\Models\User;
use App\Library\Enum;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Member-1
        $user_data = [
            'first_name'  => 'Sarowar',
            'last_name'   => 'Hossain',
            'email'       => 'sarowar@member.com',
            'password'    => bcrypt(12345678),
            'phone'       => '018456544',
            'operator_id' => 1,
            'dob'         => '1999-02-01',
            'gender'      => getDropdown(Enum::CONFIG_DROPDOWN_GENDER)[0],
            'user_type'   => Enum::USER_TYPE_CUSTOMER,
            'status'      => Enum::USER_STATUS_ACTIVE
        ];

        User::create($user_data);

        //=================== Member-2 ======================//
        $user_data2 = [
            'first_name'  => 'Rakib',
            'last_name'   => 'Hossain',
            'email'       => 'rakib@member.com',
            'password'    => bcrypt(12345678),
            'phone'       => '01845689674',
            'operator_id' => 1,
            'dob'         => '1999-02-01',
            'gender'      => getDropdown(Enum::CONFIG_DROPDOWN_GENDER)[0],
            'user_type'   => Enum::USER_TYPE_CUSTOMER,
            'status'      => Enum::USER_STATUS_ACTIVE
        ];

        User::create($user_data2);

        //===============   Member-3 ====================//
        $user_data3 = [
            'first_name'  => 'Kabir',
            'last_name'   => 'Hossain',
            'email'       => 'kabir@member.com',
            'password'    => bcrypt(12345678),
            'phone'       => '0184554545',
            'operator_id' => 1,
            'dob'         => '1999-02-01',
            'gender'      => getDropdown(Enum::CONFIG_DROPDOWN_GENDER)[0],
            'user_type'   => Enum::USER_TYPE_CUSTOMER,
            'status'      => Enum::USER_STATUS_ACTIVE
        ];

        User::create($user_data3);
    }
}
