<?php

namespace App\Livewire\Kanban;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Project;
use App\Models\Task;
use App\Models\Sprint;
use App\Models\Epic;

class Board extends Component
{
    public Project $project;

    #[Url(as: 'sprint')]
    public $selectedSprintId = null;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'task')]
    public $selectedTaskId = null;

    public $showEditEpicModal = false;
    public $showDeleteEpicModal = false;
    public $epicToEdit = null;
    public $epicToDelete = null;
    public $epicName = '';
    public $epicColor = '#3B82F6';

    protected $listeners = [
        'task-created' => '$refresh',
        'task-updated' => '$refresh',
        'openTaskDetail' => 'openTaskDetail',
        'close-task-detail' => 'closeTaskDetail',
        'openTaskDetail' => 'openTaskDetail',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;

        $firstSprint = $project->sprints()->first();
        if ($firstSprint) {
            $this->selectedSprintId = $firstSprint->id;
        }
    }

    public function openTaskDetail($taskId)
    {
        $this->selectedTaskId = $taskId;
    }

    public function closeTaskDetail()
    {
        $this->selectedTaskId = null;
    }

    public function selectSprint($sprintId)
    {
        $this->selectedSprintId = $sprintId;
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id === $this->project->id) {
            $task->update(['status' => $newStatus]);
            $this->dispatch('task-updated');
        }
    }

    public function updateTaskOrder($taskId, $newStatus, $newOrder)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id === $this->project->id) {
            $task->update([
                'status' => $newStatus,
                'order' => $newOrder
            ]);
        }
    }

    public function getTasks($status)
    {
        $query = Task::where('project_id', $this->project->id)
            ->where('status', $status);

        if ($this->selectedSprintId) {
            $query->where('sprint_id', $this->selectedSprintId);
        }

        if (!empty($this->search)) {
            $searchTerm = $this->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        return $query->orderBy('order')->get();
    }

    public function editEpic($epicId)
    {
        $this->epicToEdit = Epic::find($epicId);
        if ($this->epicToEdit && $this->epicToEdit->project_id === $this->project->id) {
            $this->epicName = $this->epicToEdit->name;
            $this->epicColor = $this->epicToEdit->color;
            $this->showEditEpicModal = true;
        }
    }

    public function closeEditEpicModal()
    {
        $this->showEditEpicModal = false;
        $this->reset(['epicToEdit', 'epicName', 'epicColor']);
        $this->resetValidation();
    }

    public function updateEpic()
    {
        $this->validate([
            'epicName' => 'required|string|max:255',
            'epicColor' => 'required|string',
        ]);

        if ($this->epicToEdit) {
            $this->epicToEdit->update([
                'name' => $this->epicName,
                'color' => $this->epicColor,
            ]);

            $this->closeEditEpicModal();
            $this->dispatch('flash-success', 'Epic modifié avec succès !');
        }
    }

    public function confirmDeleteEpic($epicId)
    {
        $this->epicToDelete = Epic::find($epicId);
        if ($this->epicToDelete && $this->epicToDelete->project_id === $this->project->id) {
            $this->showDeleteEpicModal = true;
        }
    }

    public function deleteEpic()
    {
        if ($this->epicToDelete) {
            $this->epicToDelete->delete();
            $this->showDeleteEpicModal = false;
            $this->reset(['epicToDelete']);
            $this->dispatch('flash-success', 'Epic supprimé avec succès !');
        }
    }

    public function render()
    {
        $sprints = $this->project->sprints;

        // Calculer le pourcentage d'avancement pour chaque epic
        $epics = $this->project->epics()
            ->withCount(['tasks as total_tasks', 'tasks as completed_tasks' => function ($query) {
                $query->where('status', 'done');
            }])
            ->get()
            ->map(function ($epic) {
                $epic->progress = $epic->total_tasks > 0
                    ? round(($epic->completed_tasks / $epic->total_tasks) * 100)
                    : 0;
                return $epic;
            });

        $todoTasks = $this->getTasks('todo');
        $inProgressTasks = $this->getTasks('in_progress');
        $doneTasks = $this->getTasks('done');

        return view('livewire.kanban.board', [
            'sprints' => $sprints,
            'epics' => $epics,
            'todoTasks' => $todoTasks,
            'inProgressTasks' => $inProgressTasks,
            'doneTasks' => $doneTasks,
        ]);
    }
}
