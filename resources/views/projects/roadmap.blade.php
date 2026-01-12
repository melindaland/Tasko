<x-layout.project title="Roadmap - {{ $project->name }}" :project="$project" activeTab="roadmap">
    @livewire('roadmap.board', ['project' => $project], key('roadmap-'.$project->id))
</x-layout.project>
