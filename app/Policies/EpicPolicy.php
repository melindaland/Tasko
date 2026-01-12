<?php

namespace App\Policies;

use App\Models\Epic;
use App\Models\User;

class EpicPolicy
{
    /**
     * Chef de Projet et Membres peuvent créer des epics
     */
    public function create(User $user)
    {
        return in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet et Membres peuvent modifier les epics
     */
    public function update(User $user, Epic $epic)
    {
        $project = $epic->project;
        return ($project->owner_id === $user->id || $project->isMember($user->id))
               && in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet peut supprimer tous les epics
     * Membres peuvent supprimer uniquement leurs propres epics
     */
    public function delete(User $user, Epic $epic)
    {
        $project = $epic->project;

        // Chef de Projet peut tout supprimer
        if ($project->owner_id === $user->id && $user->role === 'project_manager') {
            return true;
        }

        // Membre peut supprimer uniquement ses propres epics
        return $epic->created_by === $user->id && $user->role === 'student';
    }
}
