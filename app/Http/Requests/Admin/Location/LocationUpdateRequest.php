<?php

namespace App\Http\Requests\Admin\Location;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
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
            'name'    => ['required', 'string', 'max:255', 'unique:locations,name,' . $this->id],
            'ip'      => ['nullable', 'string', 'max:255', 'unique:locations,ip,' . $this->id],
            'details' => ['nullable', 'string'],
        ];
    }
}
