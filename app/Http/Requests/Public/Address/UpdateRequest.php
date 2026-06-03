<?php

namespace App\Http\Requests\Public\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'street_address' => ['nullable', 'string', 'max:255'],
            'thana_id'       => ['required', 'integer'],
            'area_id'        => ['nullable', 'integer'],
            'division_id'    => ['required', 'integer'],
            'district_id'    => ['required', 'integer'],
            'latitude'       => ['nullable', 'string', 'max:255'],
            'longitude'      => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
