<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->country_code && $this->phone) {
            $phone = $this->country_code . '-' . $this->phone;
            $this->merge(['phone' => $phone]);
        }

        // System Details Validation
        if ($this->system_details) {
            $systemDetails = $this->system_details;
            $this->merge(['system_details' => $systemDetails]);
        }

        // System Details Validation
        if ($this->communication) {
            $communication = $this->communication;
            $this->merge(['communication' => $communication]);
        }

        // Time & Date Validation
        if ($this->dateTime) {
            $dateTime = $this->dateTime;
            $this->merge(['dateTime' => $dateTime]);
        }

        // Currency Validation
        if ($this->currency) {
            $currency = $this->currency;
            $this->merge(['currency' => $currency]);
        }
    }

    public function rules()
    {
        return [
            // System Details
            'app_title'     => ['required_with:systemDetails', 'string', 'max:255'],
            'version'       => ['nullable', 'string', 'max:255'],
            'copyright'     => ['nullable', 'string', 'max:255'],
            'copyright_url' => ['nullable', 'string', 'max:255'],
            'website'       => ['nullable', 'string'],

            // Address
            'state'    => ['nullable', 'string', 'max:255'],
            'city'     => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'country'  => ['nullable', 'string', 'max:30'],
            'address'  => ['nullable', 'string', 'max:255'],

            // Communication
            'country_code' => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:255'],
            'email'        => ['required_with:communication', 'string', 'max:255'],
            'ticket_email' => ['nullable', 'string', 'max:255'],

            // Multimedia
            'logo'           => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
            'width'          => ['nullable', 'numeric'],
            'height'         => ['nullable', 'numeric'],
            'favicon'        => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif,JPEG'],
            'og_image'       => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
            'login_logo'     => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],
            'login_bg_image' => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],

            // Time Zone
            'date_format'  => ['required_with:dateTime', 'string', 'max:255'],
            'time_format'  => ['required_with:dateTime', 'string', 'max:255'],
            'app_timezone' => ['required_with:dateTime', 'string', 'max:255'],

            // Currency
            'currency_name'      => ['nullable', 'string', 'max:25'],
            'currency_symbol'    => ['required_with:currency', 'string', 'max:25'],
            'currency_position'  => ['nullable', 'string', 'max:255'],
            'decimal_separator'  => ['nullable', 'string', 'max:255'],
            'thousand_separator' => ['nullable', 'string', 'max:255'],
            'number_of_decimal'  => ['nullable', 'string', 'max:255'],

            // POS
            'invoice_prefix'                => ['nullable', 'string', 'max:255'],
            'return_invoice_prefix'         => ['nullable', 'string', 'max:255'],
            'invoice_start_from'            => ['nullable', 'string', 'max:255'],
            'return_invoice_start_from'     => ['nullable', 'string', 'max:255'],
            'sku_prefix'                    => ['nullable', 'string', 'max:255'],
            'barcode_prefix'                => ['nullable', 'string', 'max:255'],
            'low_stock_alert'               => ['nullable', 'numeric'],
            'vat_amount'                    => ['nullable', 'numeric'],
            'notification_time'             => ['nullable', 'string', 'max:255'],
            'invoice_logo'                  => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],

            'first_settlement_date'  => ['nullable', 'string', 'max:255'],
            'second_settlement_date' => ['nullable', 'string', 'max:255'],

            // Courier
            'extra_charge_after_weight'      => ['nullable', 'numeric'],
            'extra_charge_for_inside_dhaka'  => ['nullable', 'numeric'],
            'extra_charge_for_outside_dhaka' => ['nullable', 'numeric'],
            'extra_charge_for_sub_dhaka'     => ['nullable', 'numeric'],
            'penalty_amount'                 => ['nullable', 'numeric'],

            // Color
            'btn_primary'               => ['nullable', 'string', 'max:255'],
            'btn_secondary'             => ['nullable', 'string', 'max:255'],
            'btn_light'                 => ['nullable', 'string', 'max:255'],
            'btn_disabled'              => ['nullable', 'string', 'max:255'],
            'btn_primary_text'          => ['nullable', 'string', 'max:255'],
            'btn_secondary_text'        => ['nullable', 'string', 'max:255'],
            'btn_light_text'            => ['nullable', 'string', 'max:255'],
            'btn_primary_hover'         => ['nullable', 'string', 'max:255'],
            'btn_secondary_hover'       => ['nullable', 'string', 'max:255'],
            'btn_light_hover'           => ['nullable', 'string', 'max:255'],
            'btn_disabled_hover'        => ['nullable', 'string', 'max:255'],
            'btn_primary_text_hover'    => ['nullable', 'string', 'max:255'],
            'btn_secondary_text_hover'  => ['nullable', 'string', 'max:255'],
            'btn_light_text_hover'      => ['nullable', 'string', 'max:255'],
            'text_heading'              => ['nullable', 'string', 'max:255'],
            'general_text'              => ['nullable', 'string', 'max:255'],
            'tab_color'                 => ['nullable', 'string', 'max:255'],
            'card_heading'              => ['nullable', 'string', 'max:255'],
            'bg_color'                  => ['nullable', 'string', 'max:255'],
            'card_heading_text'         => ['nullable', 'string', 'max:255'],
            'card_bg'                   => ['nullable', 'string', 'max:255'],
            'table_heading'             => ['nullable', 'string', 'max:255'],
            'table_btn'                 => ['nullable', 'string', 'max:255'],
            'table_btn_hover'           => ['nullable', 'string', 'max:255'],
            'table_heading_text'        => ['nullable', 'string', 'max:255'],

            // Frontend color
            'primary_color'             => ['nullable', 'string', 'max:255'],
            'secondary_color'           => ['nullable', 'string', 'max:255'],
            'accent_color'              => ['nullable', 'string', 'max:255'],
            'background_color'          => ['nullable', 'string', 'max:255'],
            'breadcrumb_bg_color'       => ['nullable', 'string', 'max:255'],
            'footer_color'              => ['nullable', 'string', 'max:255'],
            'general_color'             => ['nullable', 'string', 'max:255'],
            'heading_text'              => ['nullable', 'string', 'max:255'],
            'secondary_text'            => ['nullable', 'string', 'max:255'],
            'card_color'                => ['nullable', 'string', 'max:255'],
            'card_hover_color'          => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'app_title'          => 'App Title fields is required.',
            'email'              => 'The email field is required.',
            'date_format'        => 'The date format field is required.',
            'time_format'        => 'The time format field is required.',
            'app_timezone'       => 'The time zone field is required.',
            'currency_symbol'    => 'The currency symbol field is required.',
        ];
    }
}
