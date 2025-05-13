<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'roles.required' => 'At least one role is required',
            'roles.array' => 'Roles must be provided as a list',
            'roles.*.exists' => 'One or more selected roles do not exist',
        ];
    }
}
