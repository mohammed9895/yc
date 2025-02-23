<?php

namespace App\Policies;

use App\Models\ContractorField;
use App\Models\LinkedinDitales;
use App\Models\User;

class ContractorFieldPolicy
{
    /**
     * Decontractor::fieldine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_contractor::field');
    }

    /**
     * Decontractor::fieldine whether the user can view the model.
     */
    public function view(User $user, ContractorField $contractorField): bool
    {
        return $user->can('view_contractor::field');
    }

    /**
     * Decontractor::fieldine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_contractor::field');
    }

    /**
     * Decontractor::fieldine whether the user can update the model.
     */
    public function update(User $user, ContractorField $contractorField): bool
    {
        return $user->can('update_contractor::field');
    }

    /**
     * Decontractor::fieldine whether the user can delete the model.
     */
    public function delete(User $user, ContractorField $contractorField): bool
    {
        return $user->can('delete_contractor::field');
    }

    /**
     * Decontractor::fieldine whether the user can restore the model.
     */
    public function restore(User $user, ContractorField $contractorField): bool
    {
        return $user->can('restore_contractor::field');
    }

    /**
     * Decontractor::fieldine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContractorField $contractorField): bool
    {
        return $user->can('force_delete_contractor::field');
    }
}
