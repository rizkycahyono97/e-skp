<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKegiatan extends Model
{
    protected $fillable = ['nama'];

    public function workResults(): HasMany
    {
        return $this->hasMany(WorkResult::class, 'jenis_kegiatan_id');
    }
}
