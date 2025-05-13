<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'photo' => ['required', 'image', 'max:2048'], // 2MB max
        ];

        // Only require password for new users
        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        } else {
            $rules['password'] = ['sometimes', 'confirmed', Password::defaults()];
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id];
            $rules['phone'] = ['required', 'string', 'max:20', 'unique:users,phone,' . $this->user->id];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            'phone.max' => 'Phone number cannot exceed 20 characters',
            'photo.required' => 'Profile photo is required',
            'photo.image' => 'The file must be an image',
            'photo.max' => 'Image size cannot exceed 2MB',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password confirmation does not match',
        ];
    }
}
