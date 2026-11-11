<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'user', 'guard_name' => 'web']);

        Role::create(['name' => 'Admin', 'guard_name' => 'web']);

        Role::create(['name' => 'Manager', 'guard_name' => 'web']);
    }
}
