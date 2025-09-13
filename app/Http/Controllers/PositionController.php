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
        $header = [
            'title' => 'Manajemen Posisi',
            'description' => 'Kelola Master Posisi disini.',
        ];

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Positions', 'url' => null],
        ];

        $positions = Position::latest()->paginate(10);

        return view('positions.index', compact('positions', 'header', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Positions', 'url' => route('positions.index')],
            ['name' => 'Create', 'url' => null],
        ];


        return view('positions.create', compact('breadcrumbs'));
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
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Position', 'url' => route('positions.index')],
            ['name' => 'Show', 'url' => null],
        ];

        $fields = [
            ['label' => 'ID', 'value' => $position->id],
            ['label' => 'Name', 'value' => $position->position_name],
            ['label' => 'Created At', 'value' => $position->created_at],
            ['label' => 'Updated At', 'value' => $position->updated_at],
        ];

        return view('positions.show', compact('position', 'breadcrumbs', 'fields'));
    }

    public function edit(Position $position)
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Positions', 'url' => route('positions.index')],
            ['name' => 'Edit', 'url' => null],
        ];

        return view('positions.edit', compact('position','breadcrumbs'));
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
