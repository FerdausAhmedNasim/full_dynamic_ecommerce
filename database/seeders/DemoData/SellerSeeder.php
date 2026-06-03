<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\Address;
use App\Models\Area;
use App\Models\Role;
use App\Models\User;
use Faker\Generator;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\StoreLanguage;
use App\Models\SellerCategory;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;

class SellerSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSeller();
    }

    private function createSeller()
    {
        
    }
}
