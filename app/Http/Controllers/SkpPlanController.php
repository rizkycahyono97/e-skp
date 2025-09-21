<?php

namespace App\Http\Controllers;

use App\Models\SkpPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SkpPlanController extends Controller
{
    public function index()
    {
        $header = [
            'title' => 'Manajemen SKP',
            'description' => 'Kelola SKP disini.'
        ];

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'SKP', 'url' => null],
        ];

        $skps = SkpPlan::where('user_id', Auth::id())->latest()->paginate(10);

        return view('skp-plans.index', compact('breadcrumbs', 'skps', 'header'));
    }
}
