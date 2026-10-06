<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', Rule::in(['cash', 'card'])],
            // 'address_id'   => ['required', Rule::exists('addresses', 'id')->where('user_id', auth()->id())], // добавьте, если в форме есть выбор адреса
        ];
    }
}
