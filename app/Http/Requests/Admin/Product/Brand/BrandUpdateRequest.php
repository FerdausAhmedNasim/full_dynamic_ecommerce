<?php

namespace App\Http\Requests\Admin\Product\Brand;

use Illuminate\Foundation\Http\FormRequest;

class BrandUpdateRequest extends FormRequest
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
            'name'      => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'file', 'max:512','mimes:jpeg,jpg,png','dimensions:width=145, height=120'],
        ];
    }
}
