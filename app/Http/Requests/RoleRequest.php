<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'guard_name' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Role name is required',
            'name.unique' => 'This role name is already taken',
            'guard_name.required' => 'Guard name is required',
            'permissions.required' => 'At least one permission is required',
            'permissions.array' => 'Permissions must be provided as a list',
            'permissions.*.exists' => 'One or more selected permissions do not exist',
        ];
    }
}
