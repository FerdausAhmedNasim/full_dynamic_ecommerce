<?php

namespace App\Http\Requests\Admin\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // $this->merge(['operator_id' => auth()->id()]);
    }
    public function rules(): array
    {
        return [
            'street_address' => ['required', 'string', 'max:255'],
            'thana_id'       => ['required', 'integer'],
            'area_id'        => ['required', 'integer'],
            'division_id'    => ['required', 'integer'],
            'district_id'    => ['required', 'integer'],
            'latitude'       => ['nullable', 'string', 'max:255'],
            'longitude'      => ['nullable', 'string', 'max:255'],
        ];
    }
}
