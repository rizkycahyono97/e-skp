<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class WorkResult extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'skp_id',
        'pa_id',
        'description',
        'penugasan_dari',
        'is_from_cascading'
    ];

    // 1:M with work_realizations
    public function workRealizations(): HasMany
    {
        return $this->hasMany(WorkRealization::class, 'work_result_id');
    }

    // 1:M with indicators
    public function indicators(): HasMany
    {
        return $this->hasMany(Indicator::class, 'work_result_id', 'id');
    }

    // 1:M with work_cascadings
    // public function workCascadings(): HasMany
    // {
    //     return $this->hasMany(WorkCascading::class, 'parent_work_result_id');
    // }

    // 1:M with performance_feedback
    public function performanceFeedbacks(): HasMany
    {
        return $this->hasMany(PerformanceFeedback::class, 'work_result_id');
    }

    // 1:M with skp_plans
    public function skpPlan(): BelongsTo
    {
        return $this->belongsTo(SkpPlan::class, 'skp_id');
    }

     // 1:M performanceAgreement
    public function performanceAgreement(): BelongsTo
    {
        return $this->belongsTo(PerformanceAgreement::class, 'pa_id', 'id');
    }

    public function jenisKegiatan(): BelongsTo
    {
        return $this->belongsTo(JenisKegiatan::class, 'jenis_kegiatan_id');
    }
}
