<?php

namespace Database\Seeders\SystemData;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // Backend Color Settings
            ['key' => 'btn_primary', 'value' => '#4ACE8B'],
            ['key' => 'btn_secondary', 'value' => '#4269c2'],
            ['key' => 'btn_light', 'value' => '#d1e1ff'],
            ['key' => 'btn_disabled', 'value' => '#d6d6d6'],
            ['key' => 'btn_primary_text', 'value' => '#ffffff'],
            ['key' => 'btn_secondary_text', 'value' => '#ffffff'],
            ['key' => 'btn_light_text', 'value' => '#000000'],
            ['key' => 'btn_primary_hover', 'value' => '#0dbb62'],
            ['key' => 'btn_secondary_hover', 'value' => '#1d439a'],
            ['key' => 'btn_light_hover', 'value' => '#6f91e2'],
            ['key' => 'btn_disabled_hover', 'value' => '#b0b0b0'],
            ['key' => 'btn_primary_text_hover', 'value' => '#ffffff'],
            ['key' => 'btn_secondary_text_hover', 'value' => '#ffffff'],
            ['key' => 'btn_light_text_hover', 'value' => '#000000'],
            ['key' => 'text_heading', 'value' => '#005C2D'],
            ['key' => 'general_text', 'value' => '#000000'],
            ['key' => 'tab_color', 'value' => '#ebfff1'],
            ['key' => 'card_heading', 'value' => '#4ACE8B'],
            ['key' => 'card_heading_text', 'value' => '#ffffff'],
            ['key' => 'card_bg', 'value' => '#ffffff'],
            ['key' => 'bg_color', 'value' => '#F5F7FF'],
            ['key' => 'table_heading', 'value' => '#ebfff1'],
            ['key' => 'table_heading_text', 'value' => '#005C2D'],
            ['key' => 'table_btn', 'value' => '#f0f9f3'],
            ['key' => 'table_btn_hover', 'value' => '#C1FCD3'],

            // Frontend Color Settings
            ['key' => 'primary_color', 'value' => '#0DA487'],
            ['key' => 'secondary_color', 'value' => '#0e947a'],
            ['key' => 'accent_color', 'value' => '#f77016'],
            ['key' => 'background_color', 'value' => '#ffffff'],
            ['key' => 'breadcrumb_bg_color', 'value' => '#f8f8f8'],
            ['key' => 'footer_color', 'value' => '#f8f8f8'],
            ['key' => 'general_color', 'value' => '#ffffff'],
            ['key' => 'heading_text', 'value' => '#000000'],
            ['key' => 'secondary_text', 'value' => '#4a5568'],
            ['key' => 'card_color', 'value' => '#f1f1f3'],
            ['key' => 'card_hover_color', 'value' => '#0DA487'],
            
        ];

        Config::insert($data);
    }
}
