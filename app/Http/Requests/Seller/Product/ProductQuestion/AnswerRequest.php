<?php

namespace App\Http\Requests\Seller\Product\ProductQuestion;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'       => ['required'],
            'question' => ['required', 'string'],
            'answer'   => ['required', 'string'],
        ];
    }
}
