<?php

namespace App\Http\Requests\Admin\User\Seller\Note;

use Illuminate\Foundation\Http\FormRequest;

class NoteUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'title'       => ['required', 'string', 'max:555'],
            'description' => ['required', 'string'],
        ];
    }
}
