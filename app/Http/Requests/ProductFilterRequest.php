<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    /**
     * Разрешить выполнение запроса.
     * Здесь можно проверять права пользователя.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации query-параметров.
     */
    public function rules(): array
    {
        return [
            'search'    => ['nullable', 'string', 'max:255'],
            'category'  => ['nullable', 'integer', 'exists:categories,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'gte:min_price'],
            'sort'      => ['nullable', 'in:name,price,created_at'],
            'order'     => ['nullable', 'in:asc,desc'],
            'page'      => ['nullable', 'integer', 'min:1'],
            'per_page'  => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Кастомные сообщения об ошибках (опционально).
     */
    public function messages(): array
    {
        return [
            'category.exists'  => 'Выбранная категория не найдена.',
            'max_price.gte'    => 'Максимальная цена должна быть больше минимальной.',
        ];
    }

    /**
     * Приведение типов до валидации (опционально).
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'page'     => $this->input('page', 1),
            'per_page' => $this->input('per_page', 20),
            'sort'     => $this->input('sort', 'created_at'),
            'order'    => $this->input('order', 'desc'),
        ]);
    }
}

