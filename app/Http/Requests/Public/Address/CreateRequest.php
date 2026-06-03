<?php

namespace App\Http\Requests\Public\Address;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id' => authId()]);
    }

    public function rules()
    {
        return [
            // All Data for Address Table
            'street_address' => ['nullable', 'string', 'max:255'],
            'thana_id'       => ['required', 'integer'],
            'area_id'        => ['nullable', 'integer'],
            'division_id'    => ['required', 'integer'],
            'district_id'    => ['required', 'integer'],
            'latitude'       => ['nullable', 'string', 'max:255'],
            'longitude'      => ['nullable', 'string', 'max:255'],
            'user_id'        => ['nullable', 'integer'],
            // 'area_text'           => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
