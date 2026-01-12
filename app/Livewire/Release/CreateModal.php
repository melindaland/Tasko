<?php

namespace App\Livewire\Release;

use App\Models\Project;
use App\Models\Release;
use Livewire\Component;

class CreateModal extends Component
{
    public Project $project;
    public $showModal = false;

    public $name = '';
    public $version = '';
    public $release_date = '';
    public $description = '';
    public $status = 'planned';

    protected $rules = [
        'name' => 'required|string|max:255',
        'version' => 'nullable|string|max:50',
        'release_date' => 'required|date',
        'description' => 'nullable|string',
        'status' => 'required|in:planned,in_progress,released',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'version', 'release_date', 'description', 'status']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        Release::create([
            'project_id' => $this->project->id,
            'name' => $this->name,
            'version' => $this->version,
            'release_date' => $this->release_date,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('flash-success', 'Release créée avec succès');
        $this->closeModal();

        $this->dispatch('release-created')->to('roadmap.board');
    }

    public function render()
    {
        return view('livewire.release.create-modal');
    }
}
