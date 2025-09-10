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
        $roles = Role::latest()->paginate(10);
        
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
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
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
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
