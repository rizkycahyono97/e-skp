<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class PerformanceFeedback extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'feedback_note',
        'rating'
    ];

    // 1:M with skp_evaluations
    public function skpEvaluation(): BelongsTo
    {
        return $this->belongsTo(SkpEvaluation::class, 'evaluation_id', 'evaluation_id');
    }

    // 1:M with work_results
    public function workResult(): BelongsTo
    {
        return $this->belongsTo(workResult::class, 'work_result_id', 'work_result_id');
    }

    // 1:M with user
    public function userProvided(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provided_by_id', 'user_id');
    }
}
