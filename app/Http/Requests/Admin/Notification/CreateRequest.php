<?php

namespace App\Http\Requests\Admin\Notification;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'user_type'   => ['nullable', 'array'],
            'user_status' => ['nullable', 'array'],
            'subject'     => ['required', 'string'],
            'message'     => ['required', 'string'],
            'send_date'   => ['nullable', 'date'],
        ];
    }
}
