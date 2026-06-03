<?php

namespace Database\Seeders\SystemData;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = app_path('Files/districts.json');

        $fileContents = File::get($filePath);

        $jsonData = json_decode($fileContents, true);

        $districts = collect($jsonData)->map(function($district) {
            return [
                'division_id' => $district['division_id'],
                'en_name' => $district['name'],
                'bn_name' => $district['bn_name'],
            ];
        });

        District::insert($districts->toArray());
    }
}
