<?php

namespace App\Http\Requests\Admin\Attachments;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 'name'       => ['required', 'string', 'max:255'],
            'attachment' => ['required', 'file', 'max:2048','mimes:jpeg,jpg,png,gif,pdf,docx'],
        ];
    }
}
