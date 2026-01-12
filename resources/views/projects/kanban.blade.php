<x-layout.project title="Kanban - {{ $project->name }}" :project="$project" activeTab="kanban">
    <div class="h-full">
        @if (session('success'))
            <div class="mb-6 bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @livewire('kanban.board', ['project' => $project], key('kanban-board-'.$project->id))

        @livewire('task.detail-modal')
    </div>
</x-layout.project>
