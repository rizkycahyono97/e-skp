<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Models\PerformanceAgreement;

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

        $pas = PerformanceAgreement::latest()->paginate(10);
            
        return view('performanceAgreements.index', compact('header', 'breadcrumbs', 'pas'));
    }

    public function show($id): View
    {

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Performance Agreements', 'url' => route('performance-agreements.index')],
            ['name' => 'Show PK', 'url' => null]
        ];

        $pa = PerformanceAgreement::with('workResults.indicators')->findOrFail($id);

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
}
