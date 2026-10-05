<?php

declare(strict_types=1);

namespace App\Http\Requests;

// app/Http/Requests/OrderStoreRequest.php

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'in:cash,card'],
        ];
    }
}
