<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'photo' => ['required', 'image', 'max:2048'], // 2MB max
            'category_id' => ['required', 'exists:categories,id'],
            'merchant_id' => ['required', 'exists:merchants,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'description.required' => 'Product description is required',
            'price.required' => 'Product price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price cannot be negative',
            'stock.required' => 'Stock quantity is required',
            'stock.integer' => 'Stock must be a whole number',
            'stock.min' => 'Stock cannot be negative',
            'photo.required' => 'Product photo is required',
            'photo.image' => 'The file must be an image',
            'photo.max' => 'Image size cannot exceed 2MB',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
            'merchant_id.required' => 'Merchant is required',
            'merchant_id.exists' => 'Selected merchant does not exist',
        ];
    }
}
