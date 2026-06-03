<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'code'              => ['required', 'min:4', Rule::unique('coupons')->ignore($this->coupon->id)],
            'discount'          => ['required', 'numeric'],
            'discount_type'     => ['required'],
            'maximum_discount'  => ['nullable', 'numeric'],
            'start_date'        => ['nullable'],
            'end_date'          => ['nullable'],
        ];
    }
}
