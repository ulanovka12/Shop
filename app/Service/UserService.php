<?php

namespace App\Service;

use App\DTOs\RegisterDto;
use App\DTOs\UpdateProfileDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function register(RegisterDto $dto): User
    {
        $user = new User();
        $user->name     = $dto->name;
        $user->email    = $dto->email;
        $user->password = Hash::make($dto->password); // см. примечание ниже

        if (! $user->save()) {
            throw new \RuntimeException('save() вернул false — запись не создана');
        }

        return $user;
    }

    public function updateProfile(UpdateProfileDto $dto, ?User $user = null): User
    {
        $user ??= auth()->user();

        $user->name  = $dto->name;
        $user->email = $dto->email;

        // Если email меняется, обычно нужно сбросить верификацию:
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Если в DTO есть пароль и он задан
        if (! empty($dto->password)) {
            $user->password = Hash::make($dto->password);
        }

        if (! $user->save()) {
            throw new \RuntimeException('save() вернул false — запись не создана');
        }

        return $user;
    }
    public function updatePassword(
        User $user,
        string $currentPassword,
        string $newPassword
    ): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages(['current_password' => 'Invalid current password']);
        }

        $user->password = Hash::make($newPassword);
        $user->save();
    }
}
