<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\Position;
use App\Models\SkpPlan;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkCascading;
use App\Models\WorkResult;
use Illuminate\Http\Request;

class workCascadingController extends Controller
{
    /**
     * form untuk membuat cascading dari work_result
     */
    public function create(Request $request, Indicator $indicator)
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Work Cascading', 'url' => null],
            ['name' => 'Create', 'url' => null]
        ];

        $parentIndicator = Indicator::with('workResult.performanceAgreement.user')->findOrFail($indicator->id);
        
        $units = Unit::all();
        $positions = Position::all();
        // $roles = Role::all();

        $query = User::with(['unit', 'position', 'roles']);

        if ($request->filled('unit')) {
            $query->where('unit_id', $request->unit);
        }
        if ($request->filled('position')) {
            $query->where('position_id', $request->position);
        }
        // if ($request->filled('role')) {
        //     $query->whereHas('roles', fn($q) => $q->where('name', $request->role));
        // }

        $users = $query->latest()->paginate(10)->withQueryString();

        // dd($parentIndicator->toArray());

        return view('workCascadings.create', [
            'parentIndicator' => $parentIndicator,
            'users'            => $users,
            'units'            => $units,
            'positions'        => $positions,
            // 'roles'            => $roles,
            'filters'          => $request->only(['unit', 'position']),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_indicator_id' => 'required|exists:indicators,id',
            'child_skp_id' => 'nullable|integer',
            'child_pa_id' => 'nullable|integer',
        ]);

        WorkCascading::create($validated);

        return redirect()->back()->with('success', 'Cascading berhasil dibuat');
    }
}
