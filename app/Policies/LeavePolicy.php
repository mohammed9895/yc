<?php

namespace App\Policies;

use App\Models\Leave;
use App\Models\LinkedinDitales;
use App\Models\User;

class LeavePolicy
{
    /**
     * Deleaveine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_leave');
    }

    /**
     * Deleaveine whether the user can view the model.
     */
    public function view(User $user, Leave $leave): bool
    {
        return $user->can('view_leave');
    }

    /**
     * Deleaveine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_leave');
    }

    /**
     * Deleaveine whether the user can update the model.
     */
    public function update(User $user, Leave $leave): bool
    {
        return $user->can('update_leave');
    }

    /**
     * Deleaveine whether the user can delete the model.
     */
    public function delete(User $user, Leave $leave): bool
    {
        return $user->can('delete_leave');
    }

    /**
     * Deleaveine whether the user can restore the model.
     */
    public function restore(User $user, Leave $leave): bool
    {
        return $user->can('restore_leave');
    }

    /**
     * Deleaveine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Leave $leave): bool
    {
        return $user->can('force_delete_leave');
    }
}
