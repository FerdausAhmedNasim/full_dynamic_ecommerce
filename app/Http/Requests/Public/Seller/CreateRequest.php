<?php

namespace App\Http\Requests\Public\Seller;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            // All Data For User Table
            'user.first_name' => ['required', 'string', 'max:25'],
            'user.last_name'  => ['required', 'string', 'max:25'],
            'user.email'      => ['required', 'unique:users,email', 'string', 'max:255'],
            'user.password'   => ['required', 'string', 'min:8', 'confirmed'],
            'user.phone'      => ['required', 'unique:users,phone', 'string', 'max:14', 'min:11'],

            // Store
            'store.license_no' => ['nullable', 'string'],
            'store.logo'       => ['nullable', 'file', 'max:1500', 'mimes:jpeg,jpg,png,gif'],

            // Store language
            'store_lan.store_name'    => ['required', 'string'],
            'store_lan.store_tagline' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'user.password.min' => 'The password must be at least 8 characters.',
            'user.password'     => 'Password and Confirm Password does not match.',

            'user.first_name.max'      => 'The First Name must be Max 25 characters.',
            'user.first_name.required' => 'The First Name is Required.',

            'user.last_name.max'       => 'The Last Name must be Max 25 characters.',
            'user.first_name.required' => 'The Last Name is Required.',

            'user.email.max'      => 'The Email must be at least 255 characters.',
            'user.email.required' => 'The Email is Required.',
            'user.email.unique' => 'The email has already been taken.',

            'user.phone.max'      => 'The Phone must be Max 14 characters.',
            'user.phone.min'      => 'The Phone must be at least 11 characters.',
            'user.phone.required' => 'The Phone is Required.',
            'user.phone.unique' => 'The phone has already been taken.',

            'store.logo.required' => 'The Logo is Required.',
            'store.logo.max'      => 'The Logo must be Max 1500KB.',
            'store.logo.mimes'    => 'The Logo Type must be jpeg,jpg,png,gif.',

            'store_lan.store_name.required'    => 'The Store Name is Required.',
            'store_lan.store_tagline.required' => 'The Store tagline is Required.',
        ];
    }

}
