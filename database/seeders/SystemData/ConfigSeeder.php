<?php

namespace Database\Seeders\SystemData;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // General Settings
            ['key' => 'app_title', 'value' => ''],
            ['key' => 'admin_prefix', 'value' => 'admin'],
            ['key' => 'seller_prefix', 'value' => 'seller'],
            ['key' => 'version', 'value' => 'V-1.0'],
            ['key' => 'copyright', 'value' => ''],
            ['key' => 'copyright_url', 'value' => ''],
            ['key' => 'website', 'value' => ''],

            // Communication
            ['key' => 'country_code', 'value' => ''],
            ['key' => 'phone', 'value' => ''],
            ['key' => 'email', 'value' => ''],
            ['key' => 'ticket_email', 'value' => ''],

            // Address
            ['key' => 'city', 'value' => ''],
            ['key' => 'state', 'value' => ''],
            ['key' => 'zip_code', 'value' => ''],
            ['key' => 'country', 'value' => ''],
            ['key' => 'address', 'value' => ''],

            // Multimedia
            ['key' => 'logo', 'value' => ''],
            ['key' => 'favicon', 'value' => ''],
            ['key' => 'og_image', 'value' => ''],
            ['key' => 'login_logo', 'value' => ''],
            ['key' => 'login_bg_image', 'value' => ''],

            // Date & Time
            ['key' => 'system_launch_date', 'value' => '2023-01-01'],
            ['key' => 'date_format', 'value' => 'DD-MM-YYYY'],
            ['key' => 'time_format', 'value' => '24h'],
            ['key' => 'app_timezone', 'value' => 'Asia/Dhaka'],

            // Currency
            ['key' => 'currency_name', 'value' => 'Dollar'],
            ['key' => 'currency_symbol', 'value' => '$'],
            ['key' => 'number_of_decimal', 'value' => '2'],
            ['key' => 'currency_position', 'value' => ''],
            ['key' => 'decimal_separator', 'value' => '.'],
            ['key' => 'thousand_separator', 'value' => ''],

            // POS
            ['key' => 'vat_amount', 'value' => ''],
            ['key' => 'invoice_prefix', 'value' => ''],
            ['key' => 'invoice_start_from', 'value' => ''],
            ['key' => 'return_invoice_prefix', 'value' => ''],
            ['key' => 'return_invoice_start_from', 'value' => ''],
            ['key' => 'invoice_logo', 'value' => ''],
            ['key' => 'sku_prefix', 'value' => ''],
            ['key' => 'barcode_prefix', 'value' => ''],
            ['key' => 'low_stock_alert', 'value' => ''],
            ['key' => 'notification_time', 'value' => ''],

            // Email Settings
            ['key' => 'mail_mailer', 'value' => 'smtp'],
            ['key' => 'mail_host', 'value' => 'smtp.gmail.com'],
            ['key' => 'mail_port', 'value' => '587'],
            ['key' => 'mail_username', 'value' => ''],
            ['key' => 'mail_password', 'value' => ''],
            ['key' => 'mail_from_address', 'value' => 'hello@example.com'],
            ['key' => 'mail_from_name', 'value' => 'You App Name'],
            ['key' => 'mail_encryption', 'value' => 'tls'],

            // Social Link Share
            ['key' => 'facebook_link', 'value' => ''],
            ['key' => 'twitter_link', 'value' => ''],
            ['key' => 'instagram_link', 'value' => ''],
            ['key' => 'linkedin_link', 'value' => ''],
            ['key' => 'youtube_link', 'value' => ''],

            // Website Settings
            ['key' => 'cookies_status', 'value' => 0],
            ['key' => 'cookies_agreement', 'value' => ''],
            ['key' => 'seller_agreement', 'value' => ''],
            ['key' => 'customer_agreement', 'value' => ''],
            ['key' => 'privacy_agreement', 'value' => ''],
            ['key' => 'payment_agreement', 'value' => ''],

            // Website Popup
            ['key' => 'popup_title', 'value' => ''],
            ['key' => 'popup_image', 'value' => ''],
            ['key' => 'popup_show_in', 'value' => ''],
            ['key' => 'popup_description', 'value' => ''],
            ['key' => 'site_popup_status', 'value' => 0],

            // Preference
            ['key' => 'seller_system', 'value' => 0],
            ['key' => 'seller_product_auto_approve', 'value' => 0],
            ['key' => 'stock_out_product_hide', 'value' => 0],
            ['key' => 'guest_checkout', 'value' => 0],
            ['key' => 'full_payment', 'value' => 0],
            ['key' => 'advance_shipping_cost', 'value' => 0],
            ['key' => 'show_sku', 'value' => 0],
            ['key' => 'show_weight', 'value' => 0],
            ['key' => 'show_category', 'value' => 0],
            ['key' => 'show_review', 'value' => 0],
            ['key' => 'show_ratings', 'value' => 0],
            ['key' => 'allow_guest_review', 'value' => 0],
            ['key' => 'back_order', 'value' => 0],

            // Banners
            ['key' => 'login_banner', 'value' => ''],
            ['key' => 'signup_banner', 'value' => ''],
            ['key' => 'forgot_password_banner', 'value' => ''],
            ['key' => 'landing_banner', 'value' => ''],

            ['key' => 'first_settlement_date', 'value' => '1'],
            ['key' => 'second_settlement_date', 'value' => '16'],

            ['key' => 'extra_charge_after_weight', 'value' => 2],
            ['key' => 'extra_charge_for_inside_dhaka', 'value' => 15],
            ['key' => 'extra_charge_for_outside_dhaka', 'value' => 32],
            ['key' => 'extra_charge_for_sub_dhaka', 'value' => 30],
            // ['key' => 'penalty_amount', 'value' => 75],
        ];

        Config::insert($data);
    }
}
