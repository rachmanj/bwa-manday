<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'photo' => ['required', 'image', 'max:2048'], // 2MB max
            'phone' => ['required', 'string', 'max:20', 'unique:warehouses,phone'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Warehouse name is required',
            'address.required' => 'Address is required',
            'photo.required' => 'Warehouse photo is required',
            'photo.image' => 'The file must be an image',
            'photo.max' => 'Image size cannot exceed 2MB',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            'phone.max' => 'Phone number cannot exceed 20 characters',
        ];
    }
}
