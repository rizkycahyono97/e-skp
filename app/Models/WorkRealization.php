<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class WorkRealization extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'realization_desc',
        'submitted_at',
        'status'
    ];

    // 1:M with work_results
    public function workResult(): BelongsTo 
    {
        return $this->belongsTo(WorkResult::class, 'work_result_id', 'work_result_id');
    }
}
