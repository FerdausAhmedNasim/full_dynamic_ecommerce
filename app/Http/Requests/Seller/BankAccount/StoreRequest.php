<?php

namespace App\Http\Requests\Seller\BankAccount;

use App\Models\Branch;
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

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'bank_name'     => ['required'],
            'branch_name'    => ['required'],
            'account_name'    => ['required'],
            'account_number'    => ['required', 'numeric'],
            // 'routing_number'    => ['required', 'numeric', 'digits_between:4,8'],
        ];
    }
}
