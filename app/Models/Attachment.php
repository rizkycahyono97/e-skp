<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Attachment extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'type',
        'file_path',
        'file_name',
        'description',
    ];

    // 1:M with performance_agremeents
    public function performanceAgremeent(): BelongsTo 
    {
        return $this->belongsTo(PerformanceAgreement::class, 'pa_id', 'pa_id');
    }

    // 1:M with skp_plans
    public function skpPlan(): BelongsTo 
    {
        return $this->belongsTo(SkpPlan::class, 'skp_id', 'skp_id');
    }
}
