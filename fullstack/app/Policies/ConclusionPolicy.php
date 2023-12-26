<?php

namespace App\Policies;

use App\Models\Conclusion;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

class ConclusionPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $project = Filament::getTenant();
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Conclusion $conclusion): bool
    {
        $project = $conclusion->project; //we get project' owner id
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Conclusion $conclusion): bool
    {
        $project = $conclusion->project; //we get project' owner id
        return $user->id == $project->user_id;
    }
    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Conclusion $conclusion): bool
    {
        $project = $conclusion->project; //we get project' owner id
        return $user->id == $project->user_id;
    }
}
