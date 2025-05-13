<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'sub_total' => ['required', 'integer', 'min:0'],
            'tax_total' => ['required', 'integer', 'min:0'],
            'grand_total' => ['required', 'integer', 'min:0'],
            'merchant_id' => ['required', 'exists:merchants,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'integer', 'min:0'],
            'items.*.subtotal' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Customer name is required',
            'phone.required' => 'Customer phone number is required',
            'phone.max' => 'Phone number cannot exceed 20 characters',
            'sub_total.required' => 'Sub total is required',
            'sub_total.integer' => 'Sub total must be a whole number',
            'sub_total.min' => 'Sub total cannot be negative',
            'tax_total.required' => 'Tax total is required',
            'tax_total.integer' => 'Tax total must be a whole number',
            'tax_total.min' => 'Tax total cannot be negative',
            'grand_total.required' => 'Grand total is required',
            'grand_total.integer' => 'Grand total must be a whole number',
            'grand_total.min' => 'Grand total cannot be negative',
            'merchant_id.required' => 'Merchant is required',
            'merchant_id.exists' => 'Selected merchant does not exist',
            'items.required' => 'At least one item is required',
            'items.array' => 'Items must be provided as a list',
            'items.min' => 'At least one item is required',
            'items.*.product_id.required' => 'Product is required for each item',
            'items.*.product_id.exists' => 'One or more selected products do not exist',
            'items.*.quantity.required' => 'Quantity is required for each item',
            'items.*.quantity.integer' => 'Quantity must be a whole number',
            'items.*.quantity.min' => 'Quantity must be at least 1',
            'items.*.price.required' => 'Price is required for each item',
            'items.*.price.integer' => 'Price must be a whole number',
            'items.*.price.min' => 'Price cannot be negative',
            'items.*.subtotal.required' => 'Subtotal is required for each item',
            'items.*.subtotal.integer' => 'Subtotal must be a whole number',
            'items.*.subtotal.min' => 'Subtotal cannot be negative',
        ];
    }
}
