<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\RegisterDto;
use App\DTOs\UpdateProfileDto;
use App\Models\User;
use App\Jobs\SendRegistrationVerificationJob;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(RegisterDto $dto): User
    {
        $user = new User();

        $user->name     = $dto->name;
        $user->email    = $dto->email;
        $user->password = Hash::make($dto->password);

        if (!$user->save()) {
            throw new \RuntimeException('save() вернул false — запись не создана');
        }

        // 2. Отправляем задачу в RabbitMQ
        // Важно: мы делаем это ТОЛЬКО после успешного $user->save()
        SendRegistrationVerificationJob::dispatch($user->id);

        return $user;
    }

    public function updateProfile(UpdateProfileDto $dto, ?User $user = null): User
    {
        $user ??= auth()->user();

        $user->name    = $dto->name;
        $user->email   = $dto->email;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Обновление пароля, если он передан
        if (! empty($dto->password)) {
            $user->password = Hash::make($dto->password);
        }

        if (! $user->save()) {
            throw new \RuntimeException('Не удалось сохранить профиль пользователя');
        }

        return $user;
    }
    public function updatePassword(
        User $user,
        string $currentPassword,
        string $newPassword
    ): void {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages(['current_password' => 'Invalid current password']);
        }

        $user->password = Hash::make($newPassword);
        $user->save();
    }
}
