<?php

namespace App\Http\Requests\Admin\Product\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'parent_id' => ['nullable', 'integer'],
            'order'     => ['nullable', 'integer'],
            'thumbnail' => ['nullable', 'file', 'max:512','mimes:jpeg,jpg,png'],
            'icon'      => ['nullable', 'file', 'max:512','mimes:svg','dimensions:width=130, height=130'],
        ];
    }
}
