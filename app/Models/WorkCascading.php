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
    public function parentWorkResult(): BelongsTo {
        return $this->belongsTo(WorkResult::class, 'parent_work_result_id');
    }

    // 1:M with skp_plans
    public function targetPlan(): BelongsTo 
    {
        return $this->belongsTo(SkpPlan::class, 'target_plan_id');
    }
}
