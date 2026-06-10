<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Config;

class ShippingCostConfigSeeder extends Seeder
{
    public function run()
    {
        $configs = [
            'inside_dhaka'  => '60',
            'outside_dhaka' => '120',
            'sub_dhaka'     => '100',
            'extra_charge_for_inside_dhaka'  => '10',
            'extra_charge_for_outside_dhaka' => '20',
            'extra_charge_for_sub_dhaka'     => '15',
        ];

        foreach ($configs as $key => $value) {
            Config::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}