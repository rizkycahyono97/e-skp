<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Unit extends Model
{
    use HasRoles, HasFactory;

    protected $fillable = [
        'unit_name',
        'parent_unit_id'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'parent_unit_id');
    }

    // 1:M self relation
    public function child(): HasMany {
        return $this->hasMany(Unit::class, 'parent_unit_id');
    }

    // 1:M with users
    public function users(): HasMany {
        return $this->hasMany(User::class, 'unit_id');
    }

}
