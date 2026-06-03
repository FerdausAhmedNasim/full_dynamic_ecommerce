<?php

namespace App\Http\Requests\Admin\Member;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // if ($this->country_code && $this->phone) {
        //     $mobile = $this->country_code . '-' . $this->phone;
        //     $this->merge(['phone' => $mobile]);
        // }

        if ($this->dob) {
            $this->merge([
                'dob' => prepareDateValidate($this->dob)
            ]);
        }
    }

    public function rules()
    {
        return [
            // All Data For User Table
            'full_name'   => ['required', 'string', 'max:255'],
            'email'       => ['nullable', 'string', 'max:255', 'unique:users,email,' . $this->id],
            'phone'       => ['required', 'string', 'max:18', 'unique:users,phone,' . $this->id],
            'dob'         => ['nullable', 'string', 'max:255', 'date'],
            'description' => ['nullable', 'string'],
            'address'     => ['nullable', 'string'],
            'gender'      => ['nullable', 'string', 'max:255'],
            'location'    => ['nullable', 'string', 'max:255'],
            'avatar'      => ['nullable', 'file', 'max:512','mimes:jpeg,jpg,png,gif'],
            // 'customer_type' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'mobile.phone_number' => 'Only numbers (0-9) are allowed',
        ];
    }
}
