<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\LinkedinDitales;
use App\Models\User;

class IncomePolicy
{
    /**
     * Deincomeine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_income');
    }

    /**
     * Deincomeine whether the user can view the model.
     */
    public function view(User $user, Income $income): bool
    {
        return $user->can('view_income');
    }

    /**
     * Deincomeine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_income');
    }

    /**
     * Deincomeine whether the user can update the model.
     */
    public function update(User $user, Income $income): bool
    {
        return $user->can('update_income');
    }

    /**
     * Deincomeine whether the user can delete the model.
     */
    public function delete(User $user, Income $income): bool
    {
        return $user->can('delete_income');
    }

    /**
     * Deincomeine whether the user can restore the model.
     */
    public function restore(User $user, Income $income): bool
    {
        return $user->can('restore_income');
    }

    /**
     * Deincomeine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Income $income): bool
    {
        return $user->can('force_delete_income');
    }
}
