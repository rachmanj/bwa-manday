<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'photo' => ['sometimes', 'image', 'max:2048'], // 2MB max
            'category_id' => ['sometimes', 'exists:categories,id'],
            'merchant_id' => ['sometimes', 'exists:merchants,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Product name must be text',
            'name.max' => 'Product name cannot exceed 255 characters',
            'description.string' => 'Description must be text',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price cannot be negative',
            'stock.integer' => 'Stock must be a whole number',
            'stock.min' => 'Stock cannot be negative',
            'photo.image' => 'The file must be an image',
            'photo.max' => 'Image size cannot exceed 2MB',
            'category_id.exists' => 'Selected category does not exist',
            'merchant_id.exists' => 'Selected merchant does not exist',
        ];
    }
}
