<?php

namespace App\Livewire\Workspace;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProjectStats extends Component
{
    protected $listeners = [
        'project-created' => '$refresh',
        'project-joined' => '$refresh',
        'project-updated' => '$refresh'
    ];

    public function render()
    {
        $user = Auth::user();

        $totalProjects = $user->ownedProjects()->count() + $user->joinedProjects()->count();
        $createdProjects = $user->ownedProjects()->count();
        $finishedProjects = $user->ownedProjects()->whereIn('status', ['termine', 'archive'])->count()
                          + $user->joinedProjects()->whereIn('status', ['termine', 'archive'])->count();

        return view('livewire.workspace.project-stats', [
            'totalProjects' => $totalProjects,
            'createdProjects' => $createdProjects,
            'finishedProjects' => $finishedProjects,
        ]);
    }
}
