<?php

namespace App\Http\Requests\Admin\Expense;

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
            'category'  => ['required', 'string', 'max:255'],
            'title'     => ['required', 'string', 'max:255'],
            'amount'    => ['required', 'numeric'],
            'note'      => ['nullable', 'string'],
        ];
    }
}
