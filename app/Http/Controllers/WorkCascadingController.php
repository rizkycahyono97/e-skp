<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\PerformanceAgreement;
use App\Models\Position;
use App\Models\SkpPlan;
use App\Models\Unit;
use App\Models\User;
use App\Models\WorkCascading;
use App\Models\WorkResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class WorkCascadingController extends Controller
{
    public function paCreate(Request $request, Indicator $indicator)
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Work Cascading', 'url' => null],
            ['name' => 'Create', 'url' => null]
        ];

        $parentIndicator = Indicator::with('workResult.performanceAgreement.user')->findOrFail($indicator->id);
        
        // Authorization check
        // if ($parentIndicator->workResult->performanceAgreement->user->id !== Auth::id()) {
        //     abort(403, 'Anda tidak memiliki akses ke indicator ini.');
        // }

        $units = Unit::all();
        $positions = Position::all();

        $query = User::with(['unit', 'position', 'roles'])->where('id', '!=', Auth::id()); 

        if ($request->filled('unit')) {
            $query->where('unit_id', $request->unit);
        }
        if ($request->filled('position')) {
            $query->where('position_id', $request->position);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('workCascadings.pa-create', [
            'parentIndicator' => $parentIndicator,
            'users' => $users,
            'units' => $units,
            'positions' => $positions,
            'filters' => $request->only(['unit', 'position']),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function paStore(Request $request)
    {
        $request->validate([
            'parent_indicator_id' => 'required|exists:indicators,id',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        // dd($request->toArray());

        //eager loading
        $parentIndicator = Indicator::with(['workResult.performanceAgreement.user'])
            ->findOrFail($request->parent_indicator_id);

        // auth chek
        // if ($parentIndicator->workResult->performanceAgreement->user->id !== Auth::id()) {
        //     abort(403, 'Anda tidak memiliki akses ke indicator ini.');
        // }

        DB::beginTransaction();

        try {
            foreach ($request->user_ids as $userId) {
                $this->cascadeToUser($parentIndicator, $userId); //private function helper
            }

            DB::commit();

            return redirect()
                ->route('performance-agreements.show', $parentIndicator->workResult->performanceAgreement->id)
                ->with('success', 'Cascading berhasil dilakukan ke ' . count($request->user_ids) . ' user.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat melakukan cascading: ' . $e->getMessage());
        }
    }

    public function skpCreate(Request $request, Indicator  $indicator)
    {
         $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Cascading SKP', 'url' => null],
            ['name' => 'Create', 'url' => null]
        ];

        $parentIndicator = Indicator::with('workResult.skpPlan.user')->findOrFail($indicator->id);
        
        // Authorization check - pastikan indicator milik user yang login
        // if ($parentIndicator->workResult->skpPlan->user_id !== Auth::id()) {
        //     abort(403, 'Anda tidak memiliki akses ke indicator ini.');
        // }

        $currentUserUnitId = Auth::user()->unit_id;
        
        $units = Unit::where('id', $currentUserUnitId)->get(); 
        $positions = Position::all();

        $query = User::with(['unit', 'position', 'roles'])
            ->where('unit_id', $currentUserUnitId)
            ->where('id', '!=', Auth::id()); 

        if ($request->filled('position')) {
            $query->where('position_id', $request->position);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('workCascadings.skp-create', [
            'parentIndicator' => $parentIndicator,
            'users' => $users,
            'units' => $units,
            'positions' => $positions,
            'filters' => $request->only(['position', 'search']),
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function skpStore(Request $request)
    {
        $validated = $request->validate([
            'parent_indicator_id' => 'required|exists:indicators,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $parentIndicator = Indicator::with('workResult.skpPlan')->findOrFail($validated['parent_indicator_id']);
        $parentSkp = $parentIndicator->workResult->performanceAgreement;

        if (!$parentSkp) {
            return redirect()->back()->with('error', 'SKP Plan untuk atasan belum ada, tidak bisa cascading.');
        }

        $messages = [];
        $status = 'success'; 

        foreach ($validated['user_ids'] as $userId) {
            $targetUser = User::findOrFail($userId);

            $existingSkp = SkpPlan::where('user_id', $targetUser->id)
                ->where('year', $parentSkp->year)
                ->first();

            if ($existingSkp) {
                $childSkp = $existingSkp;

                $existingCascading = WorkCascading::where('parent_indicator_id', $parentIndicator->id)
                    ->where('child_skp_id', $childSkp->id)
                    ->exists();

                if ($existingCascading) {
                    $messages[] = "Indicator sudah dicascading ke user {$targetUser->name} sebelumnya.";
                    $status = 'error'; 
                    continue;
                }
            } else {
                $childSkp = SkpPlan::create([
                    'user_id' => $targetUser->id,
                    'pa_id' => null,
                    'approver_id' => $targetUser->supervisor_id ?? null,
                    'category_id' => null,
                    'year' => $parentSkp->year,
                    'duration_start' => null,
                    'duration_end' => null,
                    'status' => 'draft',
                ]);
            }

            WorkCascading::create([
                'parent_indicator_id' => $parentIndicator->id,
                'child_pa_id' => null,
                'child_skp_id' => $childSkp->id,
            ]);

            $unitName = Unit::find($targetUser->unit_id)->unit_name ?? null;
            $parentIndicator->update([
                'target' => $unitName,
                'is_cascaded' => true,
            ]);

            $messages[] = "Berhasil cascading ke user {$targetUser->name}";
        }

        return redirect()
            ->route('performance-agreements.show', $parentIndicator->workResult->performanceAgreement->id)
            ->with($status, implode(' ', $messages));
    }

    /**
     * helper cascade indicator to a specific user
     */
    protected function cascadeToUser(Indicator $parentIndicator, $userId)
    {
        $targetUser = User::findOrFail($userId);

        // Check jika sama tahunya dari targetuser
        $existingPA = PerformanceAgreement::where('user_id', $targetUser->id)
            ->where('year', $parentIndicator->workResult->performanceAgreement->year)
            ->first();

        if ($existingPA) {
            // jika pa suda ada
            $childPA = $existingPA;
            
            $existingCascading = WorkCascading::where('parent_indicator_id', $parentIndicator->id)
                ->where('child_pa_id', $childPA->id)
                ->exists();
                
            if ($existingCascading) {
                session()->forget('success');
                return redirect()->route('work-cascading.pa-create', $parentIndicator->id)
                    ->with('error', 'Indicator sudah dicascading ke user ' . $targetUser->name . ' sebelumnya.');
            }
        } else {

            // dd($targetUser->toArray());
            $childPA = PerformanceAgreement::create([
                'user_id' => $targetUser->id,
                'approver_id' => Auth::user()->id,
                'category_id' => null,
                // 'title' => "Cascading dari " . Auth::user()->name . ": " . $parentIndicator->description,
                'title' => $parentIndicator->description,
                'cascaded_from' => Auth::user()->unit->unit_name,
                'year' => $parentIndicator->workResult->performanceAgreement->year,
                'status' => 'draft',
                'submitted_at' => null,
                'approved_at' => null,
            ]);
        }

        // dd([
        //     'parent_indicator_id' => $parentIndicator->id,
        //     'child_pa_id' => $childPA->id,
        //     'target_user' => $targetUser->name
        // ]);

        WorkCascading::create([
            'parent_indicator_id' => $parentIndicator->id,
            'child_pa_id' => $childPA->id,
            'child_skp_id' => null,
        ]);

        $unitName = Unit::find($targetUser->unit_id)->unit_name;

        $parentIndicator->update([
            'target' => $unitName,
            'is_cascaded' => true,
        ]);

            // dd($parentIndicator->toArray());

        // notification
        // Notification::send($targetUser, new CascadingReceived($parentIndicator, Auth::user()));
    }
}