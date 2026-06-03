<?php

namespace App\Http\Requests\Seller\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $solution_time = ($this->hour * 60) + $this->minute ;
        $this->merge(['solution_time' => $solution_time]);
    }

    public function rules()
    {
        return [
            'comment'    => ['required', 'string', 'max:5555'],
            'attachment' => ['nullable','file', 'max:3000'],
        ];
    }
}
