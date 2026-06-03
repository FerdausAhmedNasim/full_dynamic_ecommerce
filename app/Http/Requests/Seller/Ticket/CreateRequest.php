<?php

namespace App\Http\Requests\Seller\Ticket;

use App\Library\Enum;
use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $ticket_id = Ticket::orderBy('id', 'desc')->pluck('id')->first();

        if ($ticket_id >= 1) {
            $this->merge([
                'ticket_id' => Enum::PROJECT_ID_TAG . '-' . (5000 + $ticket_id),
            ]);
        } else {
            $this->merge([
                'ticket_id' => Enum::PROJECT_ID_TAG . '-5000',
            ]);
        }

        $this->merge([
            'created_by' => auth()->id(),
        ]);
    }

    public function rules()
    {
        return [
            'ticket_id'  => ['required', 'string', 'max:255'],
            'subject'    => ['required', 'string', 'max:555'],
            'full_name'  => ['nullable', 'string', 'max:255'],
            'department' => ['required', 'string'],
            'priority'   => ['required', 'integer'],
            'message'    => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'max:3000'],
            'created_by' => ['required', 'integer'],

        ];
    }
}
