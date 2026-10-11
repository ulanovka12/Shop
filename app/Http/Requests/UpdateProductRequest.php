<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'sku'         => ['required', 'string', 'max:255',
                'unique:products,sku,' . $productId],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }
}
