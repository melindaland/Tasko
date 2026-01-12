<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Tous les rôles peuvent voir un projet s'ils en sont membres
     */
    public function view(User $user, Project $project)
    {
        return $project->owner_id === $user->id || $project->isMember($user->id);
    }

    /**
     * Seul le Chef de Projet (owner) peut créer un projet
     */
    public function create(User $user)
    {
        return in_array($user->role, ['project_manager', 'teacher']);
    }

    /**
     * Seul le Chef de Projet (owner) peut modifier le projet
     */
    public function update(User $user, Project $project)
    {
        return $project->owner_id === $user->id && $user->role === 'project_manager';
    }

    /**
     * Seul le Chef de Projet (owner) peut supprimer le projet
     */
    public function delete(User $user, Project $project)
    {
        return $project->owner_id === $user->id && $user->role === 'project_manager';
    }

    /**
     * Les membres (sauf owner) peuvent quitter le projet
     */
    public function leave(User $user, Project $project)
    {
        return $project->owner_id !== $user->id && $project->isMember($user->id);
    }

    /**
     * Chef de Projet et Membres peuvent créer des éléments (Sprints, Épics, Tâches, Releases)
     * Enseignants ne peuvent rien créer
     */
    public function createContent(User $user, Project $project)
    {
        return ($project->owner_id === $user->id || $project->isMember($user->id))
               && in_array($user->role, ['project_manager', 'student']);
    }

    /**
     * Chef de Projet peut tout modifier
     * Membres peuvent modifier les éléments du projet (mais pas le projet lui-même)
     * Enseignants ne peuvent rien modifier
     */
    public function updateContent(User $user, Project $project)
    {
        return ($project->owner_id === $user->id || $project->isMember($user->id))
               && in_array($user->role, ['project_manager', 'student']);
    }
}
