<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(): View
    {
        $positions = Position::latest()->paginate(10);

        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'position_name' => 'required|string|unique:positions',
        ]);

        Position::create($validated);

        return redirect()->route('positions.index')
                        ->with('success', 'Position created successfully');
    }

    public function show(Position $position)
    {
        return view('positions.show', compact('position'));
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position): RedirectResponse
    {
        $validate = $request->validate([
            'position_name' => 'string|unique:positions',
        ]);

        $position->update($validate);

        return redirect()->route('positions.index')
                        ->with('success', 'Position updated successfully');
    }

    public function destroy(Position $position): RedirectResponse
    {
        $position->delete();

        return redirect()->route('positions.index')
                        ->with('success', 'Position deleted successfully');
    }
}
