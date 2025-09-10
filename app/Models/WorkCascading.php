<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkCascading extends Model
{
    use HasFactory, HasRoles;
    
    // protected $fillable = [];

    // 1:M with work_result
    public function workResult(): BelongsTo {
        return $this->belongsTo(WorkResult::class, 'parent_work_result_id');
    }

    // 1:M with skp_plans
    public function skpPlan(): BelongsTo 
    {
        return $this->belongsTo(SkpPlan::class, 'child_skp_id');
    }
}
