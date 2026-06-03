<?php

namespace Database\Seeders\SystemData;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = app_path('Files/divisions.json');

        $fileContents = File::get($filePath);

        $jsonData = json_decode($fileContents, true);

        $divisions = collect($jsonData)->map(function($division) {
            return [
                'en_name' => $division['name'],
                'bn_name' => $division['bn_name'],
            ];
        });

        Division::insert($divisions->toArray());
    }
}
