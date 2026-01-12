<?php

namespace App\Policies;

use App\Models\Release;
use App\Models\User;

class ReleasePolicy
{
    /**
     * Chef de Projet et Membres peuvent créer des releases
     */
    public function create(User $user)
    {
        return in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet et Membres peuvent modifier les releases
     */
    public function update(User $user, Release $release)
    {
        $project = $release->project;
        return ($project->owner_id === $user->id || $project->isMember($user->id))
               && in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet peut supprimer toutes les releases
     * Membres peuvent supprimer uniquement leurs propres releases
     */
    public function delete(User $user, Release $release)
    {
        $project = $release->project;

        // Chef de Projet peut tout supprimer
        if ($project->owner_id === $user->id && $user->role === 'project_manager') {
            return true;
        }

        // Membre peut supprimer uniquement ses propres releases
        return $release->created_by === $user->id && $user->role === 'student';
    }
}
