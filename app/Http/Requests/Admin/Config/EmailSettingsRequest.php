<?php

namespace App\Http\Requests\Admin\Config;

use Illuminate\Foundation\Http\FormRequest;

class EmailSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mail_mailer'    => ['required', 'string', 'max:255'],
            'mail_host'      => ['required', 'string', 'max:255'],
            'mail_port'      => ['required', 'string', 'max:255'],
            'mail_username' => ['required', 'string', 'max:255'],
            'mail_password'  => ['required', 'string', 'max:255'],
            'mail_from_address' => ['required', 'string', 'max:255'],
            'mail_from_name' => ['required', 'string', 'max:255'],
            'mail_encryption' => ['required', 'string', 'max:255'],
        ];
    }
}
