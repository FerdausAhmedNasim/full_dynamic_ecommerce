<?php

namespace App\Http\Requests\public\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'max:255'],
            'phone'   => ['required', 'string', 'min:5', 'max:11'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000']
        ];
    }

    public function messages()
    {
        return [
            'phone' => '(Min 5 - Max 11) numbers are allowed',
        ];
    }
}
