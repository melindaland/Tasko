<?php

namespace App\Policies;

use App\Models\Sprint;
use App\Models\User;

class SprintPolicy
{
    /**
     * Chef de Projet et Membres peuvent créer des sprints
     */
    public function create(User $user)
    {
        return in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet et Membres peuvent modifier les sprints
     */
    public function update(User $user, Sprint $sprint)
    {
        $project = $sprint->project;
        return ($project->owner_id === $user->id || $project->isMember($user->id))
               && in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet peut supprimer tous les sprints
     * Membres peuvent supprimer uniquement leurs propres sprints
     */
    public function delete(User $user, Sprint $sprint)
    {
        $project = $sprint->project;

        // Chef de Projet peut tout supprimer
        if ($project->owner_id === $user->id && $user->role === 'project_manager') {
            return true;
        }

        // Membre peut supprimer uniquement ses propres sprints
        return $sprint->created_by === $user->id && $user->role === 'student';
    }
}
