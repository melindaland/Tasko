<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeleteModal extends Component
{
    use AuthorizesRequests;
    public Project $project;
    public $showModal = false;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function deleteProject()
    {
        $this->authorize('delete', $this->project);

        $projectName = $this->project->name;
        $this->project->delete();

        $this->dispatch('flash-success', "Le projet \"{$projectName}\" a été supprimé avec succès.");
        return redirect()->route('workspace');
    }

    public function render()
    {
        return view('livewire.project.delete-modal');
    }
}
