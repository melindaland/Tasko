<?php

namespace App\Livewire\Sprint;

use Livewire\Component;
use App\Models\Sprint;
use App\Models\Project;

class CreateModal extends Component
{
    public Project $project;
    public $showModal = false;
    public $name = '';
    public $start_date = '';
    public $end_date = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ];

    protected $messages = [
        'name.required' => 'Le nom du sprint est obligatoire.',
        'start_date.required' => 'La date de début est obligatoire.',
        'end_date.required' => 'La date de fin est obligatoire.',
        'end_date.after_or_equal' => 'La date de fin doit être après la date de début.',
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
        $this->reset(['name', 'start_date', 'end_date']);
        $this->resetValidation();
    }

    public function createSprint()
    {
        $this->validate();

        if ($this->project->start_date && $this->start_date < $this->project->start_date->format('Y-m-d')) {
            $this->addError('start_date', 'La date de début du sprint doit être après la date de début du projet (' . $this->project->start_date->format('d/m/Y') . ').');
            return;
        }

        if ($this->project->end_date && $this->end_date > $this->project->end_date->format('Y-m-d')) {
            $this->addError('end_date', 'La date de fin du sprint doit être avant la date de fin du projet (' . $this->project->end_date->format('d/m/Y') . ').');
            return;
        }

        Sprint::create([
            'project_id' => $this->project->id,
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->dispatch('flash-success', 'Sprint créé avec succès !');
        $this->closeModal();
        $this->dispatch('sprint-created')->to('roadmap.board');
    }

    public function render()
    {
        return view('livewire.sprint.create-modal');
    }
}
