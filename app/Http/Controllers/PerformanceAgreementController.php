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
use Illuminate\Support\Facades\Gate;
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

    public function show(PerformanceAgreement $performanceAgreement): View
    {
        Gate::authorize('view', $performanceAgreement);

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Performance Agreements', 'url' => route('performance-agreements.index')],
            ['name' => 'Show PK', 'url' => null]
        ];

        // $pa = PerformanceAgreement::with('workResults.indicators')
        //     ->where('id', $id)
        //     // ->where('user_id', Auth::id())
        //     ->firstOrFail();

        $performanceAgreement->load('workResults.indicators');

        // dd($pa->toArray());

        return view('performanceAgreements.show', compact('performanceAgreement', 'breadcrumbs'));
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
        Gate::authorize('update', $performanceAgreement);

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
            'title' => 'sometimes|required|string|max:255',
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

            'new_work_results' => ['nullable', 'array'],
            'new_work_results.*.description' => ['required', 'string'],
            'new_work_results.*.penugasan_dari' => ['nullable', 'string'],
            
            'new_work_results.*.new_indicators' => ['required', 'array', 'min:1'],
            'new_work_results.*.new_indicators.*.description' => ['required', 'string'],
            'new_work_results.*.new_indicators.*.target' => ['nullable', 'string'],
            'new_work_results.*.new_indicators.*.perspektif' => ['nullable', 'string'],
        ]);

        // if ($performanceAgreement->status !== 'draft') {
        //     return redirect()->back()->with('error', 'Hanya bisa mengedit pada status draft.');
        // }

        DB::beginTransaction();

        try {
            
            // untuk validasi title jika cascade
            $updatePa = [
                'title' => $request->title,
            ];
            if ($performanceAgreement->cascaded_from) {
                unset($updatePa['title']);
            }
            $performanceAgreement->update($updatePa);

            // 1. Update existing work results dan indicators
            if ($request->has('work_results')) {
                foreach ($request->work_results as $workResultId => $workResultData) {
                    $workResult = WorkResult::find($workResultId);
                    
                    if ($workResult && $workResult->pa_id === $performanceAgreement->id) {
                        $workResult->update([
                            'description' => $workResultData['description'] ?? $workResult->description,
                            'penugasan_dari' => $workResultData['penugasan_dari'] ?? $workResult->penugasan_dari,
                        ]);
                        
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

            if ($request->has('new_indicators')) {
                foreach ($request->new_indicators as $workResultId => $newIndicatorsGrouped) {
                    $workResult = WorkResult::where('id', $workResultId)
                        ->where('pa_id', $performanceAgreement->id)
                        ->first();

                    if ($workResult) {
                        foreach ($newIndicatorsGrouped as $newIndicatorData) {
                            if (!empty($newIndicatorData['description'])) {
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
                }
            }


            if ($request->has('new_work_results')) {
                foreach ($request->new_work_results as $newWorkResultData) {
                    if (!empty($newWorkResultData['description'])) {
                        $newWorkResult = WorkResult::create([
                            'pa_id' => $performanceAgreement->id,
                            'description' => $newWorkResultData['description'],
                            'penugasan_dari' => $newWorkResultData['penugasan_dari'] ?? null,
                        ]);

                        if (isset($newWorkResultData['new_indicators']) && is_array($newWorkResultData['new_indicators'])) {
                            foreach ($newWorkResultData['new_indicators'] as $newIndicatorData) {
                                if (!empty($newIndicatorData['description'])) {
                                    Indicator::create([
                                        'work_result_id' => $newWorkResult->id,
                                        'description' => $newIndicatorData['description'],
                                        'target' => $newIndicatorData['target'] ?? null,
                                        'perspektif' => $newIndicatorData['perspektif'] ?? null,
                                        'is_from_cascading' => false,
                                    ]);
                                }
                            }
                        }
                    }
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
