<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class PerformanceAgreement extends Model
{
    use HasRoles, HasFactory;

    protected $fillable = [
        'title',
        'year',
        'status',
        'rejection_reason',
        'submitted_at',
        'approved_at',
    ];

    // 1:M with attachments
    public function attachments(): HasMany {
        return $this->hasMany(Attachment::class, 'pa_id', 'pa_id');
    }

    // 1:M with skp_plans
    public function skpPlans(): HasMany {
        return $this->hasMany(SkpPlan::class, 'pa_id', 'pa_id');
    }

    // 1:M with user
    public function user(): HasOne {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    // 1:M with user
    public function userApprover(): HasOne {
        return $this->hasOne(User::class, 'approver_id', 'user_id');
    }

    // 1:M with categories
    public function category(): HasOne {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }
}
