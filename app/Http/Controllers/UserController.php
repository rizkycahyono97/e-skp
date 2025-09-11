<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $units = Unit::all();
        $positions = Position::all();

        return view('users.create', compact('units', 'positions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:users|min:3',
            'name' => 'string|min:3',
            'username' => 'required|string|unique:users|min:3',
            'email' => 'required|string|unique:users|min:3|email',
            'password' => ['required', Password::min(3)->numbers()],       
            'unit_id' => 'required|exists:units,id',
            'position_id' => 'required|exists:positions,id',    
        ]);

        $validated['password'] =  bcrypt($validated['password']);

        User::create($validated);

        // dd($request);

        return redirect()->route('users.index')
                        ->with('success', 'User created succesfully');
    }

    public function show(User $user)
    {
        // $units = Unit::all();
        // $positions = Position::all();

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $units = Unit::all();
        $positions = Position::all();

        return view('users.edit', compact('user', 'units', 'positions'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,               
            'nip' => 'required|string|max:255|unique:users,nip,' . $user->id,
            'unit_id' => 'required|exists:units,id',
            'position_id' => 'required|exists:positions,id',
            'password' => ['nullable', 'confirmed', Password::min(3)->numbers()],            
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
                        ->with('success', 'User updated succesfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success', 'Role deleted succesfully');
    }
}
