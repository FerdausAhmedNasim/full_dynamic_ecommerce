<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use Illuminate\Database\Seeder;
use App\Models\CourierPricingPlan;

class CourierPricingPlanSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $data) {
            $data['operator_id'] = 1;
            $data['min_weight'] = 0;
            $data['max_weight'] = 1;
            $data['delivery_time'] = '3 Days';
            
            CourierPricingPlan::create($data);
        }
    }

    private function data()
    {
        return [
            [
                'pickup_location' => Enum::INSIDE_DHAKA,
                'delivery_location' => Enum::INSIDE_DHAKA,
                'price' => 14,
            ],
            [
                'pickup_location' => Enum::INSIDE_DHAKA,
                'delivery_location' => Enum::OUTSIDE_DHAKA,
                'price' => 32,
            ],
            [
                'pickup_location' => Enum::INSIDE_DHAKA,
                'delivery_location' => Enum::SUBURBS,
                'price' => 30,
            ],
            [
                'pickup_location' => Enum::OUTSIDE_DHAKA,
                'delivery_location' => Enum::INSIDE_DHAKA,
                'price' => 35,
            ],
            [
                'pickup_location' => Enum::OUTSIDE_DHAKA,
                'delivery_location' => Enum::OUTSIDE_DHAKA,
                'price' => 40,
            ],
            [
                'pickup_location' => Enum::OUTSIDE_DHAKA,
                'delivery_location' => Enum::SUBURBS,
                'price' => 45,
            ],
            [
                'pickup_location' => Enum::SUBURBS,
                'delivery_location' => Enum::INSIDE_DHAKA,
                'price' => 30,
            ],
            [
                'pickup_location' => Enum::SUBURBS,
                'delivery_location' => Enum::OUTSIDE_DHAKA,
                'price' => 35,
            ],
            [
                'pickup_location' => Enum::SUBURBS,
                'delivery_location' => Enum::SUBURBS,
                'price' => 25,
            ],
        ];
    }
}
