@props(['task', 'editMode', 'title', 'epic_id', 'sprint_id', 'description', 'due_date', 'epics', 'sprints'])

<div class="space-y-6">
    <!-- Titre -->
    <div>
        @if($editMode)
        <label class="block text-sm font-medium text-gray-400 mb-2">Titre</label>
        <input type="text" wire:model="title" class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white">
        @else
        <h3 class="text-2xl font-bold text-white mb-1">{{ $task->title }}</h3>
        @endif
    </div>

    <!-- Epic et Sprint côte à côte -->
    @if($editMode)
    <div class="grid grid-cols-2 gap-4">
        <!-- Epic -->
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
                Epic
            </label>
            <select wire:model="epic_id" class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white text-sm">
                @foreach($epics as $epic)
                <option value="{{ $epic->id }}">{{ $epic->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sprint -->
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Sprint
            </label>
            <select wire:model="sprint_id" class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white text-sm">
                @foreach($sprints as $sprint)
                <option value="{{ $sprint->id }}">{{ $sprint->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @else
    <!-- Epic et Sprint en badges -->
    <div class="flex flex-wrap gap-3">
        @if($task->epic)
        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium border"
            style="background-color: {{ $task->epic->color }}20; border-color: {{ $task->epic->color }}50; color: {{ $task->epic->color }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
            {{ $task->epic->name }}
        </span>
        @endif

        @if($task->sprint)
        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-sm font-medium bg-blue-500/20 border border-blue-500/50 text-blue-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $task->sprint->name }}
        </span>
        @endif
    </div>
    @endif

    <!-- Description -->
    <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700/50">
        <label class="block text-sm font-medium text-gray-400 mb-2 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            Description
        </label>
        @if($editMode)
        <textarea wire:model="description" rows="4" class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white"></textarea>
        @else
        <p class="text-gray-300 whitespace-pre-wrap">{{ $task->description ?? 'Aucune description' }}</p>
        @endif
    </div>

    <!-- Date d'échéance -->
    <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700/50">
        <label class="block text-sm font-medium text-gray-400 mb-2 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Date d'échéance
        </label>
        @if($editMode)
        <input type="date" wire:model="due_date" class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white">
        @else
        <div class="flex items-center gap-2">
            <span class="text-white font-medium">{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Aucune date' }}</span>
            @if($task->due_date)
            <span class="text-xs text-gray-500">({{ $task->due_date->diffForHumans() }})</span>
            @endif
        </div>
        @endif
    </div>

    <!-- Boutons d'action -->
    <div class="pt-4 border-t border-gray-700">
        @if($editMode)
        <div class="flex gap-3">
            <button wire:click="updateTask" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition font-medium">
                Enregistrer
            </button>
            <button wire:click="toggleEditMode" class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600 transition font-medium">
                Annuler
            </button>
        </div>
        @else
        <div class="flex gap-3">
            @can('update', $task)
            <button wire:click="toggleEditMode" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition font-medium">
                Modifier
            </button>
            @endcan
            @can('delete', $task)
            <button wire:click="confirmDeleteTask" class="flex-1 px-4 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition font-medium">
                Supprimer
            </button>
            @endcan
        </div>
        @endif
    </div>
</div>
