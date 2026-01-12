<?php

namespace App\Livewire\Task;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;

class CreateModal extends Component
{
    public Project $project;
    public $showModal = false;
    public $title = '';
    public $description = '';
    public $sprint_id = null;
    public $epic_id = null;
    public $assigned_to = null;
    public $due_date = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'sprint_id' => 'required|exists:sprints,id',
        'epic_id' => 'required|exists:epics,id',
        'assigned_to' => 'nullable|exists:users,id',
        'due_date' => 'required|date',
    ];

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
        $this->reset(['title', 'description', 'sprint_id', 'epic_id', 'assigned_to', 'due_date']);
        $this->resetValidation();
    }

    public function createTask()
    {
        $this->validate();

        // Valider que la date d'échéance est dans la période du sprint
        $sprint = $this->project->sprints()->find($this->sprint_id);

        if ($sprint) {
            $dueDate = \Carbon\Carbon::parse($this->due_date);

            if ($dueDate->lt($sprint->start_date) || $dueDate->gt($sprint->end_date)) {
                $this->addError('due_date',
                    'La date d\'échéance doit être comprise entre le ' .
                    $sprint->start_date->format('d/m/Y') . ' et le ' .
                    $sprint->end_date->format('d/m/Y') . ' (période du sprint).'
                );
                return;
            }
        }

        Task::create([
            'project_id' => $this->project->id,
            'title' => $this->title,
            'description' => $this->description,
            'sprint_id' => $this->sprint_id,
            'epic_id' => $this->epic_id,
            'assigned_to' => $this->assigned_to,
            'due_date' => $this->due_date ?: null,
            'status' => 'todo',
        ]);

        $this->dispatch('task-created');
        $this->closeModal();

        session()->flash('success', 'Tâche créée avec succès !');
    }

    public function render()
    {
        $sprints = $this->project->sprints;
        $epics = $this->project->epics;
        $members = $this->project->members->merge([$this->project->owner]);

        return view('livewire.task.create-modal', [
            'sprints' => $sprints,
            'epics' => $epics,
            'members' => $members,
        ]);
    }
}
