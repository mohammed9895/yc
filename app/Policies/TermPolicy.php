<?php

namespace App\Policies;

use App\Models\LinkedinDitales;
use App\Models\Term;
use App\Models\User;

class TermPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_term');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Term $term): bool
    {
        return $user->can('view_term');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_term');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Term $term): bool
    {
        return $user->can('update_term');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Term $term): bool
    {
        return $user->can('delete_term');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Term $term): bool
    {
        return $user->can('restore_term');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Term $term): bool
    {
        return $user->can('force_delete_term');
    }
}
