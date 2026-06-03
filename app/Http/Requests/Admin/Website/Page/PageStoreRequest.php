<?php

namespace App\Http\Requests\Admin\Website\Page;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            // 'link'  => ['required', 'string','unique:pages',function ($attribute, $value, $fail) {
            //     if (preg_match('/^(?!(www|http|https))\w+(.\w+)+$/', $this->link) == false) {
            //         return $fail(__('Incorrect Slug.'));
            //     }
            // }],
            'content'          => ['required', 'string'],
            'meta_title'       => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'meta_keyword'     => ['nullable', 'string'],
            'image'            => ['nullable', 'file', 'max:500', 'mimes:png,jpg,jpeg,webp,gif'],
        ];
    }
}
