<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SystemData\AreaSeeder;
use Database\Seeders\SystemData\RoleSeeder;
use Database\Seeders\SystemData\UserSeeder;
use Database\Seeders\SystemData\ColorSeeder;
use Database\Seeders\SystemData\ThanaSeeder;
use Database\Seeders\DemoData\DropdownSeeder;
use Database\Seeders\SystemData\ConfigSeeder;
use Database\Seeders\SystemData\DistrictSeeder;
use Database\Seeders\SystemData\DivisionSeeder;
use Database\Seeders\SystemData\PermissionSeeder;
use Database\Seeders\SystemData\UpdateConfigSeeder;
use Database\Seeders\SystemData\EmailTemplateSeeder;

class SystemData extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DivisionSeeder::class,
            DistrictSeeder::class,
            ThanaSeeder::class,
            AreaSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            EmailTemplateSeeder::class,
            ConfigSeeder::class,
            ColorSeeder::class,
            DropdownSeeder::class,
        ]);
    }
}
