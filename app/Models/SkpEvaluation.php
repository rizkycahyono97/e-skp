<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class SkpEvaluation extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'evaluated_by',
        'organizational_performance_score',
        'final_rating_work',
        'final_rating_behavior',
        'final_predicate',
        'evaluation_note',
        'evaluated_at'
    ];

    // 1:M with performance_feedback
    public function performanceFeedbacks(): HasMany 
    {
        return $this->hasMany(PerformanceFeedback::class, 'evaluation_id');
    }

    // 1:1 with skp_plans
    public function skpPlan(): BelongsTo
    {
        return $this->belongsTo(skpPlan::class, 'skp_id');
    }

    // 1:M with users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }
}
