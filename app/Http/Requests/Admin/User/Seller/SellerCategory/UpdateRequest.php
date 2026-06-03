<?php

namespace App\Http\Requests\Admin\User\Seller\SellerCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category_id' => ['required'],
            'commission_rate'  => ['required', 'numeric'],
        ];
    }
}
