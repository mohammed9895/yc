<?php

namespace App\Policies;

use App\Models\LinkedinDitales;
use App\Models\User;

class ContractorPolicy
{
    /**
     * Decontractorine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_contractor');
    }

    /**
     * Decontractorine whether the user can view the model.
     */
    public function view(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('view_contractor');
    }

    /**
     * Decontractorine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_contractor');
    }

    /**
     * Decontractorine whether the user can update the model.
     */
    public function update(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('update_contractor');
    }

    /**
     * Decontractorine whether the user can delete the model.
     */
    public function delete(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('delete_contractor');
    }

    /**
     * Decontractorine whether the user can restore the model.
     */
    public function restore(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('restore_contractor');
    }

    /**
     * Decontractorine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LinkedinDitales $linkedinDitales): bool
    {
        return $user->can('force_delete_contractor');
    }
}
