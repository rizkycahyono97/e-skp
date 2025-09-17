<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Models\PerformanceAgreement;
use App\Models\WorkResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PerformanceAgreementController extends Controller
{
    public function index()
    {
        $header = [
            'title' => 'Manajemen Perjanjian Kerja',
            'description' => 'Kelola Perjanjian Kerja disini.'
        ];

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Performance Agreements', 'url' => null],
        ];

        $pas = PerformanceAgreement::where('user_id', Auth::id())->latest()->paginate(10);
            
        return view('performanceAgreements.index', compact('header', 'breadcrumbs', 'pas'));
    }

    public function show($id): View
    {

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Performance Agreements', 'url' => route('performance-agreements.index')],
            ['name' => 'Show PK', 'url' => null]
        ];

        $pa = PerformanceAgreement::with('workResults.indicators')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();


        // dd($pa->toArray());

        return view('performanceAgreements.show', compact('pa', 'breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Performance Agreements', 'url' => route('performance-agreements.index')],
            ['name' => 'Create', 'url' => null],
        ];

        return view('performanceAgreements.create', compact('breadcrumbs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'work_results' => 'required|array|min:1',
            'work_results.*.description' => 'required|string',
            'work_results.*.indicators' => 'required|array|min:1',
            'work_results.*.indicators.*.description' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $pa = PerformanceAgreement::create([
                'title' => $validated['title'],
                'year' => $validated['year'],
            ]);

            foreach ($validated['work_results'] as $wrData) {
                $workResult = $pa->workResults()->create([
                    'description' => $wrData['description'],
                ]);

                foreach ($wrData['indicators'] as $indData) {
                    $workResult->indicators()->create([
                        'description' => $indData['description'],
                    ]);
                }
            }
        });

        return redirect()
            ->route('performance-agreements.index')
            ->with('success', 'Perjanjian Kerja berhasil dibuat');
    }

    public function edit(PerformanceAgreement $performanceAgreement)
    {
        // if ($performanceAgreement->status !== 'draft') {
        //     return redirect()->route('performance-agreements.index')->with('error', 'hanya bisa mengedit hasil kerja pada status draft');
        // }

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Performance Agreements', 'url' => route('performance-agreements.index')],
            ['name' => 'Edit', 'url' => null],
        ];

        return view('performanceAgreements.edit', compact('performanceAgreement', 'breadcrumbs'));
    }

    public function update(Request $request, PerformanceAgreement $performanceAgreement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'work_results' => ['nullable', 'array'],
            'work_results.*.description' => ['required', 'string'],
            'work_results.*.penugasan_dari' => ['nullable', 'string'],
            'work_results.*.indicators.*.description' => ['required', 'string'],
            'work_results.*.indicators.*.target' => ['nullable', 'string'],
            'work_results.*.indicators.*.perspektif' => ['nullable', 'string'],

            'new_indicators' => ['nullable', 'array'],
            'new_indicators.*.description' => ['required_with:new_indicators.*.target,new_indicators.*.perspektif', 'nullable', 'string'],
            'new_indicators.*.target' => ['nullable', 'string'],
            'new_indicators.*.perspektif' => ['nullable', 'string'],

            'new_work_result' => ['nullable', 'array'],
            'new_work_result.description' => ['required_with:new_work_result.penugasan_dari,new_work_result.new_indicator.description', 'nullable', 'string'],
            'new_work_result.penugasan_dari' => ['nullable', 'string'],
            'new_work_result.new_indicator.description' => ['required_with:new_work_result.new_indicator.target,new_work_result.new_indicator.perspektif', 'nullable', 'string'],
            'new_work_result.new_indicator.target' => ['nullable', 'string'],
            'new_work_result.new_indicator.perspektif' => ['nullable', 'string'],
        ]);

        // if ($performanceAgreement->status !== 'draft') {
        //     return redirect()->back()->with('error', 'Hanya bisa mengedit pada status draft.');
        // }

        DB::beginTransaction();

        try {
            
            $performanceAgreement->update([
                'title' => $request->title,
            ]);

            // 1. Update existing work results dan indicators
            if ($request->has('work_results')) {
                foreach ($request->work_results as $workResultId => $workResultData) {
                    $workResult = WorkResult::find($workResultId);
                    
                    // Pastikan work result milik PA ini
                    if ($workResult && $workResult->pa_id === $performanceAgreement->id) {
                        // Update work result
                        $workResult->update([
                            'description' => $workResultData['description'] ?? $workResult->description,
                            'penugasan_dari' => $workResultData['penugasan_dari'] ?? $workResult->penugasan_dari,
                        ]);
                        
                        // Update existing indicators
                        if (isset($workResultData['indicators'])) {
                            foreach ($workResultData['indicators'] as $indicatorId => $indicatorData) {
                                $indicator = Indicator::find($indicatorId);
                                
                                // Pastikan indicator milik work result ini
                                if ($indicator && $indicator->work_result_id === $workResult->id) {
                                    $indicator->update([
                                        'description' => $indicatorData['description'] ?? $indicator->description,
                                        'target' => $indicatorData['target'] ?? $indicator->target,
                                        'perspektif' => $indicatorData['perspektif'] ?? $indicator->perspektif,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // 2. Handle new indicators untuk existing work results
            if ($request->has('new_indicators')) {
                foreach ($request->new_indicators as $workResultId => $newIndicatorData) {
                    // Pastikan work result exists dan milik PA ini
                    $workResult = WorkResult::where('id', $workResultId)
                        ->where('pa_id', $performanceAgreement->id)
                        ->first();
                    
                    if ($workResult && !empty($newIndicatorData['description'])) {
                        Indicator::create([
                            'work_result_id' => $workResult->id,
                            'description' => $newIndicatorData['description'],
                            'target' => $newIndicatorData['target'] ?? null,
                            'perspektif' => $newIndicatorData['perspektif'] ?? null,
                            'is_from_cascading' => false,
                        ]);
                    }
                }
            }

            // 3. Add new work result jika ada
            if (!empty($request->new_work_result['description'])) {
                $newWorkResult = WorkResult::create([
                    'pa_id' => $performanceAgreement->id,
                    'description' => $request->new_work_result['description'],
                    'penugasan_dari' => $request->new_work_result['penugasan_dari'] ?? null,
                ]);

                // Add indicator untuk work result baru jika ada
                if (!empty($request->new_work_result['new_indicator']['description'])) {
                    Indicator::create([
                        'work_result_id' => $newWorkResult->id,
                        'description' => $request->new_work_result['new_indicator']['description'],
                        'target' => $request->new_work_result['new_indicator']['target'] ?? null,
                        'perspektif' => $request->new_work_result['new_indicator']['perspektif'] ?? null,
                        'is_from_cascading' => false,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('performance-agreements.index')
                ->with('success', 'Work results dan indicators berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // logger('Update Error: ' . $e->getMessage());
            // logger('Error Trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
