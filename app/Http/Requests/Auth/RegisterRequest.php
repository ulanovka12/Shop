<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Регистрация доступна всем (даже неавторизованным)
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Возвращает сообщение об ошибке на отдельное взятое правило
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Введите email',
            'email.email' => 'Неверный формат email',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован.',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'password.required' => 'Введите пароль',
            'name.required' => 'Введите имя',
        ];
    }
}
