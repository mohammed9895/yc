<?php

namespace App\Policies;

use App\Models\BittyCash;
use App\Models\LinkedinDitales;
use App\Models\User;

class BittyCashPolicy
{
    /**
     * Debitty::cashine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_bitty::cash');
    }

    /**
     * Debitty::cashine whether the user can view the model.
     */
    public function view(User $user, BittyCash $bittyCash): bool
    {
        return $user->can('view_bitty::cash');
    }

    /**
     * Debitty::cashine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_bitty::cash');
    }

    /**
     * Debitty::cashine whether the user can update the model.
     */
    public function update(User $user, BittyCash $bittyCash): bool
    {
        return $user->can('update_bitty::cash');
    }

    /**
     * Debitty::cashine whether the user can delete the model.
     */
    public function delete(User $user, BittyCash $bittyCash): bool
    {
        return $user->can('delete_bitty::cash');
    }

    /**
     * Debitty::cashine whether the user can restore the model.
     */
    public function restore(User $user, BittyCash $bittyCash): bool
    {
        return $user->can('restore_bitty::cash');
    }

    /**
     * Debitty::cashine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BittyCash $bittyCash): bool
    {
        return $user->can('force_delete_bitty::cash');
    }
}
