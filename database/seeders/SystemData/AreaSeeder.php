<?php

namespace Database\Seeders\SystemData;

use App\Models\Area;
use App\Models\Thana;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = app_path('Files/unions.json');

        $fileContents = File::get($filePath);

        $jsonData = json_decode($fileContents, true);

        $areas = collect($jsonData)->map(function($division) {
            $thana = Thana::find($division['thana_id']);
            return [
                'thana_id' => $division['thana_id'],
                'division_id' => $thana->district->division_id,
                'district_id' => $thana->district_id,
                'en_name' => $division['name'],
                'bn_name' => $division['bn_name'],
            ];
        });

        Area::insert($areas->toArray());
    }
}
