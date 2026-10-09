<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Contracts\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::orderBy('id')->get();

        return view('admin.roles.index', compact('roles'));
    }
}
