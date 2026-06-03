<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\AdvertiseLocation;
use App\Models\Location;
use Illuminate\Database\Seeder;

class AdLocationSeeder extends Seeder
{
    public function run()
    {
        //Location-1
        $data = [
            'location' => Enum::AD_LOCATION_DEAL_YOU_CAN_NOT_MISS,
            'operator_id' => 1,
            'active' => true,
        ];

        AdvertiseLocation::create($data);

        $data = [
            'location' => Enum::AD_LOCATION_FLASH_SALE,
            'operator_id' => 1,
            'active' => true,
        ];

        AdvertiseLocation::create($data);

        $data = [
            'location' => Enum::AD_LOCATION_FLASH_SALE,
            'operator_id' => 1,
            'active' => true,
        ];

        AdvertiseLocation::create($data);

        //Location-2
        // $data2 = [
        //     'name'        => 'Dunedin',
        //     'ip'          => '127.0.0.2',
        //     'operator_id' => 1,
        // ];
        // Location::create($data2);

        // $data3 = [
        //     'name'        => 'Tauranga',
        //     'ip'          => '127.0.0.3',
        //     'operator_id' => 1,
        // ];
        // Location::create($data3);

        // $data4 = [
        //     'name'        => 'Christchurch',
        //     'ip'          => '127.0.0.4',
        //     'operator_id' => 1,
        // ];
        // Location::create($data4);

        // $data5 = [
        //     'name'        => 'Wellington',
        //     'ip'          => '127.0.0.5',
        //     'operator_id' => 1,
        // ];
        // Location::create($data5);
    }
}
