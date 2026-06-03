<?php

namespace App\Http\Requests\Seller\Moderator;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        if ($this->user['phone']) {
            $this->merge(['mobile' => $this->user['phone']]);
        }

        if ($this->user['dob']) {
            $this->merge([
                'dob' => prepareDateValidate($this->user['dob'])
            ]);
        }
    }

    public function rules()
    {
        return [
            // All Data For User Table
            //'user.user_type' => ['required', 'string', 'max:255'],
            'user.first_name' => ['required', 'string', 'max:255'],
            'user.last_name'  => ['required', 'string', 'max:255'],
            'user.email'      => ['required', 'string', 'max:255', 'unique:users,email,' . $this->id],
            'mobile'          => ['required', 'string', 'max:18', 'unique:users,phone,' . $this->id],
            'dob'             => ['required', 'date'],
            'user.gender'     => ['required', 'string', 'max:255'],
            'user.location'   => ['nullable', 'string', 'max:255'],
            'user.avatar'     => ['nullable', 'file', 'max:500', 'mimes:jpeg,jpg,png,gif'],

            // All Data For Employee Table
            'employee.job_title'       => ['required', 'string', 'max:255'],
            'employee.employment_type' => ['required', 'string', 'max:255'],

            'branch.branch_id' => ['nullable', 'integer'],

            // Role
            'role_id' => ['nullable', 'array'],
        ];
    }

    public function messages()
    {
        return [
            'mobile.phone_number' => 'Only numbers (0-9) are allowed',
            //'role_id'                        => 'Role is required',
        ];
    }
}
