<?php

namespace App\Http\Requests\Admin\PickupHub;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'division_id'    => ['required'],
            'district_id'    => ['required'],
            'thana_id'       => ['required'],
            'area_id'        => ['required'],
            'street_address' => ['required', 'string', 'max:255'],
            'note'           => ['nullable', 'string', 'max:255'],
            'latitude'       => ['nullable', 'string', 'max:255'],
            'longitude'      => ['nullable', 'string', 'max:255'],
        ];
    }
}