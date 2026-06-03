<?php

namespace Database\Seeders\DemoData;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        //Location-1
        $data = [
            'name'        => 'Dhaka',
            'ip'          => '127.0.0.1',
            'operator_id' => 1,
        ];

        Location::create($data);

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
