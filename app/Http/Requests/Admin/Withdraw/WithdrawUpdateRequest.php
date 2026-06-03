<?php

namespace App\Http\Requests\Admin\Withdraw;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawUpdateRequest extends FormRequest
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
            'amount'      => ['required', 'numeric'],
            'note'        => ['nullable', 'string'],
        ];
    }
}
