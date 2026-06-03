<?php

namespace App\Http\Requests\Admin\Return\Purchase;

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
            'product_id'      => ['required', 'array'],
            'return_quantity' => ['required', 'array'],
            'sub_total'       => ['required', 'array'],
            'is_return'       => ['required', 'array'],
            'attachment'      => ['nullable', 'array'],
            'name'            => ['nullable', 'array'],

            'note'                    => ['nullable', 'string'],
            'refund_packaging_amount' => ['nullable', 'numeric'],
            'refund_delivery_amount'  => ['nullable', 'numeric'],
            'refund_discount_amount'  => ['nullable', 'numeric'],
            'total_amount'            => ['nullable', 'numeric'],
        ];
    }
}
