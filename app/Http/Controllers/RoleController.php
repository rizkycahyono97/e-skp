<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        $header = [
            'title' => 'Manajemen Role',
            'description' => 'Kelola Master role di sini.'
        ];

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Users', 'url' => null],
        ];

        $roles = Role::latest()->paginate(10);
        
        return view('roles.index', compact('roles', 'header', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Role', 'url' => route('roles.index')],
            ['name' => 'Create', 'url' => null],
        ];

        return view('roles.create', compact('breadcrumbs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated =  $request->validate([
            'name' => 'required|string|unique:roles|min:3'
        ]);
        Role::create($validated);

        return redirect()->route('roles.index')
                        ->with('success', 'Role created succesfully');
    }

    public function show(Role $role)
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Roles', 'url' => route('roles.index')],
            ['name' => 'Show', 'url' => null],
        ];

        $fields = [
            ['label' => 'ID', 'value' => $role->id],
            ['label' => 'Role Name', 'value' => $role->name],
            ['label' => 'Guard Name', 'value' => $role->guard_name],
            ['label' => 'Created At', 'value' => $role->created_at],
            ['label' => 'Updated At', 'value' => $role->updated_at],
        ];

        return view('roles.show', compact('role', 'breadcrumbs', 'fields'));
    }

    public function edit(Role $role)
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Role', 'url' => route('roles.index')],
            ['name' => 'Edit', 'url' => null],
        ];

        return view('roles.edit', compact('role', 'breadcrumbs'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated =  $request->validate([
            'name' => 'required|string|unique:roles|min:3'
        ]);
        $role->update($validated);

        return redirect()->route('roles.index')
                        ->with('success', 'Role updated succesfully');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('roles.index')
                        ->with('success', 'Role deleted succesfully');
    }
}
