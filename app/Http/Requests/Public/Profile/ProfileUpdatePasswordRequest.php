<?php

namespace App\Http\Requests\public\Profile;

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
            'current_password' => ['required', 'min:8', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, authUser()->password)) {
                    return $fail(__('The Current Password Is Incorrect.'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
