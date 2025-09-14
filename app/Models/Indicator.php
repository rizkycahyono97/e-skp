<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Indicator extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'description',
        'target',
        'perspektif'
    ];

    // 1:M with work_result
    public function workResult(): BelongsTo
    {
        return $this->belongsTo(WorkResult::class, 'work_result_id', 'id');
    }

    //  1:M with work_cascadings
    public function workCascadings(): HasMany
    {
        return $this->hasMany(WorkCascading::class, 'parent_indicator_id');
    }
}
