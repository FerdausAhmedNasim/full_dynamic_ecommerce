<?php

namespace App\Http\Requests\Admin\Advertisement\Location;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'location'     => ['required', 'unique:advertise_locations,location,' . $this->ad_location->id],
            'amount'    => ['nullable', 'numeric'],
        ];
    }
}
