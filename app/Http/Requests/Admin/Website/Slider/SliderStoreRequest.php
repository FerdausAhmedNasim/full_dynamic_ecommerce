<?php

namespace App\Http\Requests\Admin\Website\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
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
            'link'       => ['required', 'string'],
            'order'      => ['nullable', 'integer'],
            'background' => ['required', 'file', 'max:2024','mimes:jpeg,jpg,png,webp'],
        ];
    }
}
