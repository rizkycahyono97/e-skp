<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'unit_id',
        'position_id',
        'name',
        'nip',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 1:M with units
    public function unit(): BelongsTo 
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    // 1:M with positions
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    // 1:M with performance_agreements
    public function performanceAgremeents(): HasMany
    {
        return $this->hasMany(PerformanceAgreement::class, 'user_id');
    }

    // 1:M with performance_agreements
    public function performanceAgremeentApprovers(): HasMany
    {
        return $this->hasMany(PerformanceAgreement::class, 'approver_id');
    }

    // 1:M with performance_feedback
    public function performanceFeedbacks(): HasMany 
    {
        return $this->hasMany(PerformanceFeedback::class, 'provided_by_id');
    }

    // 1:M with skp_evaluations
    public function skpEvaluations(): HasMany
    {
        return $this->hasMany(SkpEvaluation::class, 'evaluated_by');
    }

    // 1:1 with skp_plans
    public function skpPlan(): HasOne {
        return $this->hasOne(SkpPlan::class, 'user_id');
    }

    // 1:M with skp_plans
    public function skpPlansApprovers(): HasMany {
        return $this->hasMany(SkpPlan::class, 'approver_id');
    }
}
