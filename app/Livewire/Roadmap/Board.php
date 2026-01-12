<?php

namespace App\Livewire\Roadmap;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Release;
use Livewire\Component;
use Carbon\Carbon;

class Board extends Component
{
    public Project $project;
    public $selectedView = 'timeline';
    public $currentMonth;
    public $currentYear;

    public $showEditSprintModal = false;
    public $showDeleteSprintModal = false;
    public $sprintToEdit = null;
    public $sprintToDelete = null;
    public $sprintName = '';
    public $sprintStartDate = '';
    public $sprintEndDate = '';

    protected $listeners = [
        'sprint-created' => '$refresh',
        'release-created' => '$refresh',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
    }

    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function goToCurrentMonth()
    {
        $now = Carbon::now();
        $this->currentMonth = $now->month;
        $this->currentYear = $now->year;
    }

    public function editSprint($sprintId)
    {
        $this->sprintToEdit = Sprint::find($sprintId);
        if ($this->sprintToEdit && $this->sprintToEdit->project_id === $this->project->id) {
            $this->sprintName = $this->sprintToEdit->name;
            $this->sprintStartDate = $this->sprintToEdit->start_date->format('Y-m-d');
            $this->sprintEndDate = $this->sprintToEdit->end_date->format('Y-m-d');
            $this->showEditSprintModal = true;
        }
    }

    public function closeEditSprintModal()
    {
        $this->showEditSprintModal = false;
        $this->reset(['sprintToEdit', 'sprintName', 'sprintStartDate', 'sprintEndDate']);
        $this->resetValidation();
    }

    public function updateSprint()
    {
        $this->validate([
            'sprintName' => 'required|string|max:255',
            'sprintStartDate' => 'required|date',
            'sprintEndDate' => 'required|date|after:sprintStartDate',
        ]);

        if ($this->sprintToEdit) {
            $this->sprintToEdit->update([
                'name' => $this->sprintName,
                'start_date' => $this->sprintStartDate,
                'end_date' => $this->sprintEndDate,
            ]);

            $this->closeEditSprintModal();
            $this->dispatch('flash-success', 'Sprint modifié avec succès !');
        }
    }

    public function confirmDeleteSprint($sprintId)
    {
        $this->sprintToDelete = Sprint::find($sprintId);
        if ($this->sprintToDelete && $this->sprintToDelete->project_id === $this->project->id) {
            $this->showDeleteSprintModal = true;
        }
    }

    public function deleteSprint()
    {
        if ($this->sprintToDelete) {
            $this->sprintToDelete->delete();
            $this->showDeleteSprintModal = false;
            $this->reset(['sprintToDelete']);
            $this->dispatch('flash-success', 'Sprint supprimé avec succès !');
        }
    }

    public function render()
    {
        $sprints = Sprint::where('project_id', $this->project->id)
            ->orderBy('start_date')
            ->get();

        $releases = Release::where('project_id', $this->project->id)
            ->orderBy('release_date')
            ->get();

        $tasks = $this->project->tasks()
            ->with('epic')
            ->orderBy('created_at')
            ->get();

        $allDates = collect();

        if ($sprints->isNotEmpty()) {
            $allDates = $allDates->merge($sprints->pluck('start_date'))
                                 ->merge($sprints->pluck('end_date'));
        }

        if ($releases->isNotEmpty()) {
            $allDates = $allDates->merge($releases->pluck('release_date'));
        }

        $startDate = $allDates->isNotEmpty() ? $allDates->min() : Carbon::now()->startOfMonth();
        $endDate = $allDates->isNotEmpty() ? $allDates->max() : Carbon::now()->addMonths(3)->endOfMonth();

        $currentDate = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $month = [
            'date' => $currentDate->copy(),
            'label' => $currentDate->translatedFormat('F Y'),
            'days' => $currentDate->daysInMonth,
            'startDate' => $currentDate->copy()->startOfMonth(),
            'endDate' => $currentDate->copy()->endOfMonth(),
        ];

        return view('livewire.roadmap.board', [
            'sprints' => $sprints,
            'releases' => $releases,
            'tasks' => $tasks,
            'month' => $month,
        ]);
    }
}
