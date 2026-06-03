<?php

namespace App\Http\Requests\Admin\User\Seller\SendMoney;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
            'note'  => ['required'],
            'payment_method'  => ['nullable'],
            'transaction_id'  => ['nullable'],
        ];
    }
}
