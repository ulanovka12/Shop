<?php

namespace App\Service;

use App\DTOs\RegisterDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(RegisterDto $dto): User
    {

        $user = new User();
        $user->name = $dto->name;
        $user->email = $dto->email;
        $user->password = Hash::make($dto->password);

        $user->save();

        return $user;
    }
}
