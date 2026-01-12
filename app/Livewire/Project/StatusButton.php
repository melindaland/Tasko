<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Livewire\Component;

class StatusButton extends Component
{
    public Project $project;
    public $showDropdown = false;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function changeStatus($newStatus)
    {
        $this->authorize('update', $this->project);

        $this->project->update(['status' => $newStatus]);

        $this->showDropdown = false;

        $this->dispatch('project-updated');

        session()->flash('success', 'Statut du projet mis à jour avec succès.');

        return redirect()->route('projects.dashboard', $this->project);
    }

    public function render()
    {
        return view('livewire.project.status-button');
    }
}
