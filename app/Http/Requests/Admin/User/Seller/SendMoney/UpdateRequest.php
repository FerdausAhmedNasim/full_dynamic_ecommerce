<?php

namespace App\Http\Requests\Admin\User\Seller\SendMoney;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
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
