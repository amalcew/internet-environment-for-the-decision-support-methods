<?php

namespace App\Policies;

use App\Models\ProjectUser;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;

class ProjectUserPolicy
{
//    TODO: Should we disable showing people who also can see this project????
//    /**
//     * Determine whether the user can view any models.
//     */
//    public function viewAny(User $user): bool
//    {
//        //
//    }
//
//    /**
//     * Determine whether the user can view the model.
//     */
//    public function view(User $user, ProjectUser $projectUser): bool
//    {
//        //
//    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $project = Filament::getTenant();
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectUser $projectUser): bool
    {
        $project = Filament::getTenant();
        return $user->id == $project->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectUser $projectUser): bool
    {
        $project = Filament::getTenant();
        return $user->id == $project->user_id;
    }
}
