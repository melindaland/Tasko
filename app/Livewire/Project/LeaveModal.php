<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeaveModal extends Component
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

    public function leaveProject()
    {
        $this->authorize('leave', $this->project);

        $this->project->members()->detach(Auth::id());

        session()->flash('success', "Vous avez quitté le projet \"{$this->project->name}\" avec succès.");
        return redirect()->route('workspace');
    }

    public function render()
    {
        return view('livewire.project.leave-modal');
    }
}
