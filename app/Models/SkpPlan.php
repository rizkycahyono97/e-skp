<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class SkpPlan extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'year',
        'duration_start',
        'duration_end',
        'status',
        'rejection_reason',
        'submitted_at',
        'approved_at',
    ];

    // 1:1 with skpEvaluations
    public function skpEvaluation(): HasOne {
        return $this->hasOne(SkpPlan::class, 'skp_id');
    }

    // 1:M with work_cascadings (pivot)
    public function workCascadings(): HasMany
    {
        return $this->hasMany(WorkCascading::class, 'child_skp_id');
    }

    // 1:M with work_result
    public function workResults(): HasMany {
        return $this->hasMany(WorkResult::class, 'skp_id');
    }

    // 1:1 with users
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 1:M with users
    public function userApprover():BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
    // 1:M with performance_agreements
    public function performanceAgreement(): BelongsTo {
        return $this->belongsTo(PerformanceAgreement::class, 'pa_id');
    }

    // 1:M with attachments
    public function attachments(): HasMany {
        return $this->hasMany(Attachment::class, 'skp_id');
    }

    // 1:M with categories
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
