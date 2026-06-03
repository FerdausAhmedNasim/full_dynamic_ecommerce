<?php

namespace App\Http\Requests\public\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['nullable', 'string', 'max:255', 'unique:users,email,' . $this->id],
            'phone'      => ['required', 'numeric', 'digits:11', 'unique:users,phone,' . $this->id],
            'dob'        => ['required', 'string', 'max:255', 'date'],
            'gender'     => ['required', 'string', 'max:255',],
            'address'   => ['nullable', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:255'],
            'avatar'   => ['nullable', 'file', 'max:512','mimes:jpeg,jpg,png,gif'],
        ];
    }
}
