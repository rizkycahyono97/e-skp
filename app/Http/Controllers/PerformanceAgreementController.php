<?php

namespace App\Http\Controllers;

use App\Models\PerformanceAgreement;
use Illuminate\Http\Request;

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
}
