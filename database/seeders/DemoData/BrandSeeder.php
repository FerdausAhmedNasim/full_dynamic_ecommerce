<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\CommonLanguage;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = Brand::factory(20)->create();

        $brands->each(function ($brand) {
            CommonLanguage::create([
                'title' => Str::of($brand->slug)->replace('-', ' ')->title(),
                'local' => 'en',
                'languageable_id' => $brand->id,
                'languageable_type' => 'App\Models\Brand'
            ]);
        });
    }
}
