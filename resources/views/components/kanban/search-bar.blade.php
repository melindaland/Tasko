@props(['search', 'sprints', 'selectedSprintId'])

<div class="mb-6 space-y-4">
    <!-- Deuxième ligne : Recherche, filtre sprint et bouton créer -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        <!-- Barre de recherche -->
        <div class="relative flex-1 sm:max-w-md">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Rechercher par titre ou description..."
                class="w-full pl-11 pr-10 py-2.5 bg-gray-800 border border-gray-700 rounded-full text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
            @if($search)
            <button wire:click="$set('search', '')"
                type="button"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            @endif
        </div>

        <!-- Filtre sprint -->
        @if($sprints->isNotEmpty())
        <select wire:model.live="selectedSprintId"
            class="px-4 py-2.5 bg-gray-800 border border-gray-700 rounded-full text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
            <option value="">Tous les sprints</option>
            @foreach($sprints as $sprint)
            <option value="{{ $sprint->id }}">{{ $sprint->name }}</option>
            @endforeach
        </select>
        @endif

        <!-- Bouton créer tâche (slot) -->
        {{ $slot }}
    </div>
</div>
