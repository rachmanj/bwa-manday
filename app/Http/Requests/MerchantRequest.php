<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:merchants,name'],
            'address' => ['required', 'string'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
            'phone' => ['required', 'string', 'max:20', 'unique:merchants,phone'],
            'keeper_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Merchant name is required',
            'name.unique' => 'This merchant name is already taken',
            'address.required' => 'Address is required',
            'photo.required' => 'Merchant photo is required',
            'photo.image' => 'The file must be an image',
            'photo.max' => 'Image size cannot exceed 2MB',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            'phone.max' => 'Phone number cannot exceed 20 characters',
            'keeper_id.required' => 'Keeper is required',
            'keeper_id.exists' => 'Selected keeper does not exist',
        ];
    }
}
