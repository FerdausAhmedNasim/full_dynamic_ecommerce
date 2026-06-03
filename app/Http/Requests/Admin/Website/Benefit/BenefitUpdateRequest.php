<?php

namespace App\Http\Requests\Admin\Website\Benefit;

use Illuminate\Foundation\Http\FormRequest;

class BenefitUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'     => ['required', 'string'],
            'sub_title' => ['required', 'string'],
            'order'     => ['nullable', 'integer'],
            'image'     => ['nullable', 'file', 'max:2024','mimes:svg'],
        ];
    }
}
