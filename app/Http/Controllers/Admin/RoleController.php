<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(RoleRequest $request)
    {
        Role::create($request->validated());

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Роль создана');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Роль обновлена');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Роль удалена');
    }
}
