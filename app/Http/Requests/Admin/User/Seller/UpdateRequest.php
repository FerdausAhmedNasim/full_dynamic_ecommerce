<?php

namespace App\Http\Requests\Admin\User\Seller;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if ($this->user['country_code'] && $this->user['phone']) {
            $mobile = $this->user['country_code'] . '-' . $this->user['phone'];
            $this->merge(['mobile' => $mobile]);
        }

        if ($this->user['dob']) {
            $this->merge([
                'dob' => prepareDateValidate($this->user['dob'])
            ]);
        }
    }

    public function rules()
    {

        return [

            // All Data For User Table
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.last_name'  => ['nullable', 'string', 'max:255'],
            'user.email'      => ['nullable', 'string', 'max:255', 'unique:users,email,' . $this->id],
            'dob'             => ['nullable', 'date'],
            'mobile'          => ['required', 'string', 'max:18', 'min:11', 'unique:users,phone,' . $this->id],
            'user.gender'     => ['nullable', 'string', 'max:255'],
            'role_id'         => ['required', 'array'],
            'user.address'    => ['nullable', 'string', 'max:555'],
            'user.location'   => ['nullable', 'string', 'max:255'],
            'user.avatar'     => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],

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

    public function messages()
    {
        return [
            'mobile.phone_number' => 'Only numbers (0-9) are allowed',
            'user.password.min'   => 'The password must be at least 8 characters !!!',
            'user.password'       => 'Password and Confirm Password does not match !!!',
        ];
    }
}
