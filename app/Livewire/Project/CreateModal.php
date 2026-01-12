<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class CreateModal extends Component
{
    public $showModal = false;
    public $showSuccessModal = false;
    public $projectName = '';
    public $accessCode = '';
    public $name = '';
    public $description = '';
    public $start_date = '';
    public $end_date = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    protected $messages = [
        'name.required' => 'Le nom du projet est obligatoire.',
        'description.required' => 'La description du projet est obligatoire.',
        'end_date.after_or_equal' => 'La date de fin doit être après la date de début.',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'description', 'start_date', 'end_date']);
        $this->resetValidation();
    }

    public function createProject()
    {
        $this->validate();

        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'owner_id' => Auth::id(),
            'access_code' => Project::generateUniqueAccessCode(),
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'status' => 'en_cours',
        ]);

        $this->projectName = $project->name;
        $this->accessCode = $project->access_code;

        $this->dispatch('project-created');
        $this->closeModal();
        $this->showSuccessModal = true;
    }

    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
        $this->reset(['projectName', 'accessCode']);
    }

    public function copyCode()
    {
        $this->dispatch('code-copied');
    }

    public function render()
    {
        return view('livewire.project.create-modal');
    }
}
