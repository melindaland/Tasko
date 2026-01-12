<?php

namespace App\Livewire\Task;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class DetailModal extends Component
{
    use WithFileUploads;

    public $taskId;
    public $task;
    public $showModal = false;
    public $attachment;
    public $editMode = false;
    public $showDeleteTaskModal = false;
    public $showDeleteFileModal = false;
    public $fileToDelete = null;

    public $title;
    public $description;
    public $sprint_id;
    public $epic_id;
    public $due_date;
    public $assigned_users = [];

    protected $listeners = ['openTaskDetail'];

    public function mount($taskId = null)
    {
        if ($taskId) {
            $this->openTaskDetail($taskId);
        }
    }

    public function openTaskDetail($taskId)
    {
        $this->taskId = $taskId;
        $this->task = Task::with(['project.sprints', 'project.epics', 'project.members', 'project.owner', 'sprint', 'epic', 'assignedUser'])->find($taskId);
        $this->showModal = true;
        $this->editMode = false;
        $this->loadTaskData();
    }

    public function loadTaskData()
    {
        $this->title = $this->task->title;
        $this->description = $this->task->description;
        $this->sprint_id = $this->task->sprint_id;
        $this->epic_id = $this->task->epic_id;
        $this->due_date = $this->task->due_date?->format('Y-m-d');
        $this->assigned_users = $this->task->assigned_users ?? [];
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
        if (!$this->editMode) {
            $this->loadTaskData();
        }
    }

    public function updateTask()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sprint_id' => 'required|exists:sprints,id',
            'epic_id' => 'required|exists:epics,id',
            'due_date' => 'nullable|date',
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'exists:users,id',
        ]);

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
            'sprint_id' => $this->sprint_id,
            'epic_id' => $this->epic_id,
            'due_date' => $this->due_date,
            'assigned_users' => $this->assigned_users,
        ]);

        $this->task->refresh();
        $this->editMode = false;
        $this->dispatch('task-updated');
        $this->dispatch('flash-success', 'Tâche mise à jour avec succès !');
    }

    public function confirmDeleteTask()
    {
        $this->showDeleteTaskModal = true;
    }

    public function deleteTask()
    {
        if ($this->task->attachments) {
            foreach ($this->task->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $this->task->delete();
        $this->showDeleteTaskModal = false;
        $this->closeModal();
        $this->dispatch('task-updated');
        $this->dispatch('flash-success', 'Tâche supprimée avec succès !');
    }

    public function confirmDeleteAttachment($index)
    {
        $this->fileToDelete = $index;
        $this->showDeleteFileModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editMode = false;
        $this->reset(['taskId', 'task', 'attachment', 'title', 'description', 'sprint_id', 'epic_id', 'due_date', 'assigned_users']);

        $this->dispatch('close-task-detail')->to('kanban.board');
    }

    public function uploadAttachment()
    {
        $this->validate([
            'attachment' => 'required|file|max:10240',
        ]);

        $path = $this->attachment->store('task-attachments', 'public');

        $attachments = $this->task->attachments ?? [];
        $attachments[] = [
            'name' => $this->attachment->getClientOriginalName(),
            'path' => $path,
            'size' => $this->attachment->getSize(),
            'uploaded_at' => now()->toDateTimeString(),
            'uploaded_by' => auth()->id(),
            'uploaded_by_name' => auth()->user()->name,
        ];

        $this->task->update(['attachments' => $attachments]);
        $this->task->refresh();

        $this->reset('attachment');
        $this->dispatch('flash-success', 'Document ajouté avec succès !');
    }

    public function downloadAttachment($index)
    {
        $attachments = $this->task->attachments;

        if (!isset($attachments[$index])) {
            $this->dispatch('flash-error', 'Fichier introuvable.');
            return;
        }

        $file = $attachments[$index];
        $filePath = storage_path('app/public/' . $file['path']);

        if (!file_exists($filePath)) {
            $this->dispatch('flash-error', 'Le fichier n\'existe plus sur le serveur.');
            return;
        }

        return response()->download($filePath, $file['name']);
    }

    public function deleteAttachment()
    {
        if ($this->fileToDelete === null) {
            $this->showDeleteFileModal = false;
            return;
        }

        $attachments = $this->task->attachments;

        if (isset($attachments[$this->fileToDelete])) {
            $fileName = $attachments[$this->fileToDelete]['name'];
            Storage::disk('public')->delete($attachments[$this->fileToDelete]['path']);
            unset($attachments[$this->fileToDelete]);
            $this->task->update(['attachments' => array_values($attachments)]);
            $this->task->refresh();
            $this->dispatch('flash-success', 'Fichier "' . $fileName . '" supprimé avec succès !');
        }

        $this->showDeleteFileModal = false;
        $this->fileToDelete = null;
    }

    public function render()
    {
        $sprints = $this->task ? $this->task->project->sprints : collect();
        $epics = $this->task ? $this->task->project->epics : collect();
        $members = $this->task ? $this->task->project->members->merge([$this->task->project->owner]) : collect();

        return view('livewire.task.detail-modal', [
            'sprints' => $sprints,
            'epics' => $epics,
            'members' => $members,
        ]);
    }
}
