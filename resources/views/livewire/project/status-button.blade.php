<div x-data="{ open: @entangle('showDropdown') }" class="relative">
    <button
        @click="open = !open"
        @can('update', $project)
        class="px-3 py-1 rounded-full text-sm font-semibold transition-all duration-200 hover:scale-105
            {{ in_array($project->status, ['termine', 'archive']) ? 'bg-green-500/10 text-green-400 border border-green-500/20 hover:bg-green-500/20' :
                'bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500/20' }}">
        {{ in_array($project->status, ['termine', 'archive']) ? 'Terminé' : 'En cours' }}
        <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    @else
    <span class="px-3 py-1 rounded-full text-sm font-semibold
        {{ in_array($project->status, ['termine', 'archive']) ? 'bg-green-500/10 text-green-400 border border-green-500/20' :
            'bg-blue-500/10 text-blue-400 border border-blue-500/20' }}">
        {{ in_array($project->status, ['termine', 'archive']) ? 'Terminé' : 'En cours' }}
    </span>
    @endcan

    @can('update', $project)
    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-xl z-50"
        style="display: none;">

        <div class="py-1">
            <button
                wire:click="changeStatus('en_cours')"
                class="w-full text-left px-4 py-2 text-sm text-blue-400 hover:bg-blue-500/10 transition-colors duration-150 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                En cours
            </button>

            <button
                wire:click="changeStatus('termine')"
                class="w-full text-left px-4 py-2 text-sm text-green-400 hover:bg-green-500/10 transition-colors duration-150 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Terminé
            </button>
        </div>
    </div>
    @endcan
</div>
