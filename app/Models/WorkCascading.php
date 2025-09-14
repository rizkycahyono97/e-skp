<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkCascading extends Model
{
    use HasFactory, HasRoles;
    
    protected $fillable = [
        'parent_work_result_id',
        'target_plan_id',
    ];

    // 1:M with work_result
    public function parentIndicator(): BelongsTo {
        return $this->belongsTo(Indicator::class, 'parent_indicator_id');
    }

    // 1:M with performanc_agreement
    public function childPerformanceAgreement(): BelongsTo 
    {
        return $this->belongsTo(PerformanceAgreement::class, 'child_pa_id');
    }

    // 1:M with skp_plans
    public function childSkpPlan(): BelongsTo
    {
        return $this->belongsTo(SkpPlan::class, 'child_skp_id');
    }
}
