<?php

namespace Database\Seeders\DemoData;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\CommonLanguage;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = Category::factory(10)->create();

        $categories->each(function ($category) {
            CommonLanguage::create([
                'title' => Str::of($category->slug)->replace('-', ' ')->title(),
                'local' => 'en',
                'languageable_id' => $category->id,
                'languageable_type' => 'App\Models\Category'
            ]);
        });

        $categories->whereBetween('id', [11, 20])->each(function ($category) {
            $category->update(['parent_id' => random_int(1, 10)]);
        });

        $categories->whereBetween('id', [21, 30])->each(function ($category) {
            $category->update(['parent_id' => random_int(11, 20)]);
        });
    }
}
