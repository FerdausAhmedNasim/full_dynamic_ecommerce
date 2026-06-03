<?php

namespace App\Http\Requests\Admin\Branch;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // protected function prepareForValidation()
    // {
    //     if($this->country_code && $this->phone) {
    //         $mobile = $this->country_code . '-' . $this->phone ;
    //         $this->merge(['phone' => $mobile]);
    //     }
    // }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:18'],
            'email'       => ['nullable', 'email', 'max:255'],
            'manager_id'  => ['required', 'integer'],
            'location_id' => ['required', 'integer'],
            'address'     => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'phone.phone_number' => 'Only numbers (0-9) are allowed',
        ];
    }
}
