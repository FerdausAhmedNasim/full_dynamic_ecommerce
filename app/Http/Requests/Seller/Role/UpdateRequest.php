<?php

namespace App\Http\Requests\Seller\Role;

use App\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // protected function prepareForValidation()
    // {
    //     $slug = str_replace(' ', '_', strtolower($this->name));
    //     $exist_slug = Role::where('slug', $slug)->where('for', 'moderator')->whereNot('id', $this->id)->first();

    //     if($exist_slug) {
    //         throw ValidationException::withMessages(['name' => 'Name is has already been taken']);
    //     }
    //     $this->merge([
    //         'slug' => $slug
    //     ]);
    // }

    public function rules()
    {
        return [
            'id'   => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->whereNotNull('seller_id')->ignore($this->role->id)],
            // 'slug' => ['required', 'string', 'max:255']
        ];
    }
}
