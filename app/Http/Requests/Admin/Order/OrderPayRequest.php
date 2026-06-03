<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderPayRequest extends FormRequest
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
            'amount'        => ['required', 'array'],
            'trx_id'        => ['required', 'array'],
            'payment_type'  => ['required', 'array'],
            'total_amount'    => ['nullable', 'numeric'],
        ];
    }
}
