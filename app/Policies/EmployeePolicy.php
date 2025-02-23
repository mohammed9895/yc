<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\LinkedinDitales;
use App\Models\User;

class EmployeePolicy
{
    /**
     * Deemployeeine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_employee');
    }

    /**
     * Deemployeeine whether the user can view the model.
     */
    public function view(User $user, Employee $employee): bool
    {
        return $user->can('view_employee');
    }

    /**
     * Deemployeeine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_employee');
    }

    /**
     * Deemployeeine whether the user can update the model.
     */
    public function update(User $user, Employee $employee): bool
    {
        return $user->can('update_employee');
    }

    /**
     * Deemployeeine whether the user can delete the model.
     */
    public function delete(User $user, Employee $employee): bool
    {
        return $user->can('delete_employee');
    }

    /**
     * Deemployeeine whether the user can restore the model.
     */
    public function restore(User $user, Employee $employee): bool
    {
        return $user->can('restore_employee');
    }

    /**
     * Deemployeeine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Employee $employee): bool
    {
        return $user->can('force_delete_employee');
    }
}
