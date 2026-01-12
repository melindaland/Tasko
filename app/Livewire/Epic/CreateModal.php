<?php

namespace App\Livewire\Epic;

use Livewire\Component;
use App\Models\Epic;
use App\Models\Project;

class CreateModal extends Component
{
    public Project $project;
    public $showModal = false;
    public $name = '';
    public $color = '#3b82f6';

    protected $rules = [
        'name' => 'required|string|max:255',
        'color' => 'required|string',
    ];

    protected $messages = [
        'name.required' => 'Le nom de l\'epic est obligatoire.',
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
        $this->reset(['name', 'color']);
        $this->resetValidation();
    }

    public function createEpic()
    {
        $this->validate();

        Epic::create([
            'project_id' => $this->project->id,
            'name' => $this->name,
            'color' => $this->color,
        ]);

        $this->dispatch('epic-created');
        $this->closeModal();

        session()->flash('success', 'Epic créé avec succès !');
    }

    public function render()
    {
        return view('livewire.epic.create-modal');
    }
}
