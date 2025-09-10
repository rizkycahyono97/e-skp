<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class Position extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'position_name'
    ];

    // 1:M with users
    public function users(): HasMany {
        return $this->hasMany(User::class, 'position_id');
    }
}
