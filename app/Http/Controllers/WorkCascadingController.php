<?php

namespace App\Http\Controllers;

use App\Models\SkpPlan;
use App\Models\WorkResult;
use Illuminate\Http\Request;

class workCascadingController extends Controller
{
    /**
     * form untuk membuat cascading dari work_result
     */
    public function create(WorkResult $workResult)
    {
        // $targets = SkpPlan::
    }
}
