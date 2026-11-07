<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Order; // <-- Импорт модели
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Импорт Rule

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => [
                'required',
                'string',
                Rule::in(Order::PAYMENT_METHODS),//константа из модельки
            ],
        ];
    }
}
