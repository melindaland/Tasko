<?php

namespace App\Livewire\Project;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class JoinModal extends Component
{
    public $showModal = false;
    public $access_code = '';

    protected $rules = [
        'access_code' => 'required|string|size:6',
    ];

    protected $messages = [
        'access_code.required' => 'Le code d\'accès est obligatoire.',
        'access_code.size' => 'Le code d\'accès doit contenir 6 chiffres.',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset('access_code');
        $this->resetValidation();
    }

    public function joinProject()
    {
        $this->validate();

        $project = Project::where('access_code', $this->access_code)->first();

        if (!$project) {
            $this->addError('access_code', 'Code d\'accès invalide.');
            return;
        }

        if ($project->owner_id === Auth::id()) {
            $this->addError('access_code', 'Vous êtes déjà le propriétaire de ce projet.');
            return;
        }

        if ($project->isMember(Auth::id())) {
            $this->addError('access_code', 'Vous êtes déjà membre de ce projet.');
            return;
        }

        $project->members()->attach(Auth::id(), ['role' => 'member']);

        $this->dispatch('project-joined');
        $this->closeModal();

        session()->flash('success', 'Vous avez rejoint le projet "' . $project->name . '" avec succès !');
    }

    public function render()
    {
        return view('livewire.project.join-modal');
    }
}
