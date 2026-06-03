<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DemoData\PageSeeder;
use Database\Seeders\DemoData\BrandSeeder;
use Database\Seeders\DemoData\SellerSeeder;
use Database\Seeders\DemoData\ProductSeeder;
use Database\Seeders\DemoData\CategorySeeder;
use Database\Seeders\DemoData\LocationSeeder;
use Database\Seeders\DemoData\AdLocationSeeder;
use Database\Seeders\DemoData\CourierPricingPlanSeeder;

class DemoData extends Seeder
{
    public function run()
    {
        $this->call([
            // LocationSeeder::class,
            // BrandSeeder::class,
            // CategorySeeder::class,
            // SellerSeeder::class,
            // ProductSeeder::class,
            // AdLocationSeeder::class,
            PageSeeder::class,
            CourierPricingPlanSeeder::class,
        ]);
    }
}
