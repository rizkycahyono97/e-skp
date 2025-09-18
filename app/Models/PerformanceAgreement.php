<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class PerformanceAgreement extends Model
{
    use HasRoles, HasFactory;

    protected $casts = [
        'submitted_at' => 'date',
        'approved_at' => 'date',
    ];

    protected $fillable = [
        'user_id',
        'approver_id',
        'category_id',
        'title',
        'cascaded_from',
        'year',
        'status',
        'rejection_reason',
        'submitted_at',
        'approved_at',
    ];

    // 1:M with attachments
    public function attachments(): HasMany {
        return $this->hasMany(Attachment::class, 'pa_id');
    }

    // 1:M with skp_plans
    public function skpPlans(): HasMany {
        return $this->hasMany(SkpPlan::class, 'pa_id');
    }

    // 1:M with user
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // 1:M with user
    public function userApprover(): HasOne {
        return $this->hasOne(User::class, 'approver_id');
    }

    // 1:M with categories
    public function category(): HasOne {
        return $this->hasOne(Category::class, 'category_id');
    }

    public function workResults(): HasMany
    {
        return $this->hasMany(WorkResult::class, 'pa_id', 'id');
    }

    public function workCascadings(): HasMany
    {
        return $this->hasMany(WorkCascading::class, 'child_pa_id');
    }
}
