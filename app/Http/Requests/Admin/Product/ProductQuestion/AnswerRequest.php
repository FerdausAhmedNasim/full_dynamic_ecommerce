<?php

namespace App\Http\Requests\Admin\Product\ProductQuestion;

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
            'question' => ['required', 'string', 'max:255'],
            'answer'   => ['required', 'string', 'max:1000'],
        ];
    }
}
