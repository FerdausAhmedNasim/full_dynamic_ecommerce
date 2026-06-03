<?php

namespace App\Http\Requests\Admin\Return\Sale;

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
