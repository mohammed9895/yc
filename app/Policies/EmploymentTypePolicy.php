<?php

namespace App\Policies;

use App\Models\LinkedinDitales;
use App\Models\User;

class EmploymentTypePolicy
{
    /**
     * Deemployment::typeine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_employment::type');
    }

    /**
     * Deemployment::typeine whether the user can view the model.
     */
    public function view(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('view_employment::type');
    }

    /**
     * Deemployment::typeine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_employment::type');
    }

    /**
     * Deemployment::typeine whether the user can update the model.
     */
    public function update(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('update_employment::type');
    }

    /**
     * Deemployment::typeine whether the user can delete the model.
     */
    public function delete(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('delete_employment::type');
    }

    /**
     * Deemployment::typeine whether the user can restore the model.
     */
    public function restore(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('restore_employment::type');
    }

    /**
     * Deemployment::typeine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('force_delete_employment::type');
    }
}
