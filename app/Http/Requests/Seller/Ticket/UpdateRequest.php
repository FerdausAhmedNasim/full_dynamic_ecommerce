<?php

namespace App\Http\Requests\Seller\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => auth()->id(),
        ]);
    }

    public function rules()
    {
        return [
            'subject'    => ['required', 'string', 'max:555'],
            'full_name'  => ['nullable', 'string', 'max:255'],
            'department' => ['required', 'string'],
            'priority'   => ['required', 'integer'],
            'message'    => ['required', 'string', 'max:5555'],
            'attachment' => ['nullable','file', 'max:2048'],
            'created_by' => ['required', 'integer'],

        ];
    }
}
