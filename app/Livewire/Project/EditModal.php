<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditModal extends Component
{
    use AuthorizesRequests;
    public Project $project;
    public $showModal = false;
    public $name;
    public $description;
    public $start_date;
    public $end_date;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->start_date = $project->start_date?->format('Y-m-d');
        $this->end_date = $project->end_date?->format('Y-m-d');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updateProject()
    {
        $this->authorize('update', $this->project);
        $this->validate();

        $this->project->update([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
        ]);

        $this->closeModal();
        $this->dispatch('flash-success', 'Projet modifié avec succès !');
        return redirect()->route('projects.dashboard', $this->project);
    }

    public function render()
    {
        return view('livewire.project.edit-modal');
    }
}
