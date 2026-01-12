<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Chef de Projet et Membres peuvent créer des tâches
     */
    public function create(User $user)
    {
        return in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet et Membres peuvent modifier les tâches
     */
    public function update(User $user, Task $task)
    {
        $project = $task->project;
        return ($project->owner_id === $user->id || $project->isMember($user->id))
               && in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet peut supprimer toutes les tâches
     * Membres peuvent supprimer uniquement leurs propres tâches
     */
    public function delete(User $user, Task $task)
    {
        $project = $task->project;

        // Chef de Projet peut tout supprimer
        if ($project->owner_id === $user->id && $user->role === 'project_manager') {
            return true;
        }

        // Membre peut supprimer uniquement ses propres tâches
        return $task->created_by === $user->id && $user->role === 'student';
    }
}
