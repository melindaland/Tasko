<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    public function dashboard(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.dashboard', compact('project'));
    }

    public function kanban(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.kanban', compact('project'));
    }

    public function roadmap(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.roadmap', compact('project'));
    }
}
