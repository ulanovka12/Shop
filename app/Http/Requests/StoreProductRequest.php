<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // проверка прав
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'sku'         => ['required', 'string', 'unique:products,sku'],
            'is_active' => ['boolean'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
        ];
    }
}
