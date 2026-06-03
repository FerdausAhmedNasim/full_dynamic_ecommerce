<?php

namespace App\Http\Requests\Seller\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, auth()->user()->password)) {
                    return $fail(__('The Current Password Is Incorrect.'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
