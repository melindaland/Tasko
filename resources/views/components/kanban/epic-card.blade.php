@props(['epic'])

<div class="flex-shrink-0 w-80 bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700/50 p-5 hover:border-blue-500/50 transition group">
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <div class="w-4 h-4 rounded-full flex-shrink-0" style="background-color: {{ $epic->color }};"></div>
            <h4 class="text-lg font-semibold text-white truncate">{{ $epic->name }}</h4>
        </div>
        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">
            @can('update', $epic)
                <button wire:click="editEpic({{ $epic->id }})"
                        class="p-2 hover:bg-gray-700 rounded-lg text-yellow-400 transition"
                        title="Modifier l'epic">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            @endcan
            @can('delete', $epic)
                <button wire:click="confirmDeleteEpic({{ $epic->id }})"
                        class="p-2 hover:bg-gray-700 rounded-lg text-orange-400 transition"
                        title="Supprimer l'epic">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            @endcan
        </div>
    </div>

    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span>{{ $epic->completed_tasks ?? 0 }} / {{ $epic->total_tasks ?? 0 }} tâches</span>
    </div>

    <div>
        <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
            <span>Avancement</span>
            <span class="font-semibold">{{ $epic->progress ?? 0 }}%</span>
        </div>
        <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-500"
                 style="width: {{ $epic->progress ?? 0 }}%; background-color: {{ $epic->color }}"></div>
        </div>
    </div>
</div>
