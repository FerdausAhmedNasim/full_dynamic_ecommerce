<?php

namespace App\Http\Requests\Admin\AreaSettings\Thana;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'division_id' => ['required'],
            'district_id' => ['required'],
            'en_name'     => ['required', 'string', 'max:255'],
        ];
    }
}