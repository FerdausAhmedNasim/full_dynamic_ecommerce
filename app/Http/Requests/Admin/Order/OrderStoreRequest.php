<?php

namespace App\Http\Requests\Admin\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'purchase_date' => ['required', 'string'],
            'product_id'     => ['required', 'array'],
            'quantity'       => ['required', 'array'],
            'purchase_price' => ['required', 'array'],
            'sale_price'     => ['required', 'array'],
            'special_price'  => ['required', 'array'],
            'stock_alert'    => ['required', 'array'],
            'warranty_date'  => ['required', 'array'],
            'sub_total'      => ['required', 'array'],

            'note'            => ['nullable', 'string'],
            'packaging_cost'  => ['nullable', 'numeric'],
            'delivery_cost'   => ['nullable', 'numeric'],
            'discount_amount' => ['nullable', 'numeric'],
            'total_amount'    => ['nullable', 'numeric'],
        ];
    }
}
