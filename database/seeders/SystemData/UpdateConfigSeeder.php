<?php

namespace Database\Seeders\SystemData;

use App\Models\Config;
use Illuminate\Database\Seeder;

class UpdateConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            
            ['key' => 'return_invoice_prefix', 'value' => ''],
            ['key' => 'return_invoice_start_from', 'value' => ''],

            // Shipping Cost
            ['key' => 'inside_dhaka', 'value' => 70],
            ['key' => 'outside_dhaka', 'value' => 150],
        ];

        Config::insert($data);
    }
}
