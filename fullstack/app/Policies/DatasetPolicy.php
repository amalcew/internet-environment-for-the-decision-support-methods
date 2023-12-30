<?php

namespace App\Policies;

use App\Models\Dataset;
use App\Models\Project;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

/**
 * Only owner can update,
 * delete turn off when any project based on data exists
 */
class DatasetPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Dataset $dataset): bool
    {
        return $user->id == $dataset->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Dataset $dataset): bool
    {
        if ($user->is_admin) {
            return true;
        }
        if ($user->id != $dataset->user_id) {
            return false;
        }
        $projs = $dataset->projects->count();
        return !$projs;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Dataset $dataset): bool
    {
        if ($user->is_admin) {
            return true;
        }
        if ($user->id != $dataset->user_id) {
            return false;
        }
        $projs = $dataset->projects->count();
        return !$projs;
    }
}
