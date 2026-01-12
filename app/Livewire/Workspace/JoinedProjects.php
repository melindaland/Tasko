<?php

namespace App\Livewire\Workspace;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JoinedProjects extends Component
{
    protected $listeners = ['project-joined' => '$refresh'];

    public function render()
    {
        $projects = Auth::user()->joinedProjects()->latest()->get();

        return view('livewire.workspace.joined-projects', [
            'projects' => $projects,
        ]);
    }
}
