@props(['epics', 'project'])

<div class="mt-8 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-white flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            Epics
        </h3>
    </div>

    @if($epics->isNotEmpty())
    <div class="relative">
        <div class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-900">
            <div class="flex gap-4 min-w-max">
                @foreach($epics as $epic)
                <x-kanban.epic-card :epic="$epic" />
                @endforeach
            </div>
        </div>
    </div>
    @else
        @can('createContent', $project)
            @livewire('epic.create-modal', ['project' => $project], key('create-epic-'.$project->id))
        @else
            <p class="text-gray-400 text-sm">Aucun epic créé. Vous n'avez pas les permissions pour en créer.</p>
        @endcan
    @endif
</div>
