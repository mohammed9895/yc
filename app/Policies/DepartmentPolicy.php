<?php

namespace App\Policies;

use App\Models\Department;
use App\Models\LinkedinDitales;
use App\Models\User;

class DepartmentPolicy
{
    /**
     * Dedepartmentine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_department');
    }

    /**
     * Dedepartmentine whether the user can view the model.
     */
    public function view(User $user, Department $department): bool
    {
        return $user->can('view_department');
    }

    /**
     * Dedepartmentine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_department');
    }

    /**
     * Dedepartmentine whether the user can update the model.
     */
    public function update(User $user, Department $department): bool
    {
        return $user->can('update_department');
    }

    /**
     * Dedepartmentine whether the user can delete the model.
     */
    public function delete(User $user, Department $department): bool
    {
        return $user->can('delete_department');
    }

    /**
     * Dedepartmentine whether the user can restore the model.
     */
    public function restore(User $user, Department $department): bool
    {
        return $user->can('restore_department');
    }

    /**
     * Dedepartmentine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Department $department): bool
    {
        return $user->can('force_delete_department');
    }
}
