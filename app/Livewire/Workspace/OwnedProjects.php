<?php

namespace App\Livewire\Workspace;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OwnedProjects extends Component
{
    protected $listeners = ['project-created' => '$refresh'];

    public function render()
    {
        $projects = Auth::user()->ownedProjects()->latest()->get();

        return view('livewire.workspace.owned-projects', [
            'projects' => $projects,
        ]);
    }
}
