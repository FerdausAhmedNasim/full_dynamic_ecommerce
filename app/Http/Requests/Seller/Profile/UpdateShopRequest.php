<?php

namespace App\Http\Requests\Seller\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Store
            'store.license_no' => ['nullable', 'string'],
            'store.logo'       => ['nullable', 'file', 'max:1500', 'mimes:jpeg,jpg,png,gif'],
            'store.banner'     => ['nullable', 'file', 'max:1500', 'mimes:jpeg,jpg,png,gif'],
            'store.facebook'   => ['nullable', 'string'],
            'store.google'     => ['nullable', 'string'],
            'store.twitter'    => ['nullable', 'string'],
            'store.instagram'  => ['nullable', 'string'],
            'store.youtube'    => ['nullable', 'string'],
            'store.twitter'    => ['nullable', 'string'],

            // Store language
            'store_lan.store_name'       => ['required', 'string'],
            'store_lan.store_tagline'    => ['required', 'string'],
            'store_lan.address'          => ['nullable', 'string'],
            'store_lan.meta_title'       => ['nullable', 'string'],
            'store_lan.meta_description' => ['nullable', 'string'],
        ];
    }
}
