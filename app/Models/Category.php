<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = ['category_name'];

    // 1:M with performance_agreements
    public function performanceAgremeents(): HasMany {
        return $this->hasMany(PerformanceAgreement::class, 'category_id');
    }

    // 1:M with skp_plans
    public function skpPlans(): HasMany {
        return $this-> hasMany(SkpPlan::class, 'category_id');
    }
}
