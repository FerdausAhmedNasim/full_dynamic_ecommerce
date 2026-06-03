<?php

namespace Database\Seeders\SystemData;

use App\Models\Thana;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ThanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = app_path('Files/thanas.json');

        $fileContents = File::get($filePath);

        $jsonData = json_decode($fileContents, true);

        $thanas = collect($jsonData)->map(function($thana) {
            return [
                'district_id' => $thana['district_id'],
                'en_name' => $thana['name'],
                'bn_name' => $thana['bn_name'],
            ];
        });

        Thana::insert($thanas->toArray());
    }
}
