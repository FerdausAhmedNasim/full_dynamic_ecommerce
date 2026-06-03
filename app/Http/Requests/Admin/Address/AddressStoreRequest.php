<?php

namespace App\Http\Requests\Admin\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'user_id'               => ['required', 'integer'],
            'street_address'   => ['required', 'string', 'max:255'],
            'state'           => ['required', 'string', 'max:255'],
            'city'             => ['required', 'string', 'max:255'],
            'post_code'        => ['required', 'integer'],
            'latitude'         => ['required', 'string', 'max:255'],
            'longitude'        => ['required', 'string', 'max:255'],
        ];
    }
}
