<?php

namespace App\Policies;

use App\Models\PerformanceAgreement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PerformanceAgreementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        return $user->id === $performanceAgreement->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        return $user->id === $performanceAgreement->user_id && in_array($performanceAgreement->status, ['draft', 'reverted']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        return $user->id === $performanceAgreement->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        return false;
    }

    // custom policy
    public function submit(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        // submit harus status pa === 'draft' atau 'reverted'
        return $user->id === $performanceAgreement->user_id && in_array($performanceAgreement->status, ['draft', 'reverted']);
    }

    public function approve(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        return $user->id === $performanceAgreement->approver_id && $performanceAgreement->status === 'submitted';
    }

    public function revert(User $user, PerformanceAgreement $performanceAgreement): bool
    {
        return $this->approve($user, $performanceAgreement);
    }
}
