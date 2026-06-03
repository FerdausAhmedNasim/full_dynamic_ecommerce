<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'quantity'        => ['required', 'array'],
            'sale_price'      => ['required', 'array'],
            'sub_total'       => ['required', 'array'],
            'deleted_product' => ['nullable'],

            'note'            => ['nullable', 'string'],
            'packaging_cost'  => ['nullable', 'numeric'],
            'delivery_cost'   => ['nullable', 'numeric'],
            'discount_amount' => ['nullable', 'numeric'],
            'total_amount'    => ['nullable', 'numeric'],
        ];
    }
}
