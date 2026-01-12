@props(['sprint'])

@php
$now = \Carbon\Carbon::now();
$isActive = $now->between($sprint->start_date, $sprint->end_date);
$isPast = $now->gt($sprint->end_date);
$isFuture = $now->lt($sprint->start_date);

$duration = $sprint->start_date->diffInDays($sprint->end_date) + 1;
$daysRemaining = $isActive ? round($now->diffInDays($sprint->end_date)) : 0;
@endphp

<div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700/50 p-4 hover:border-blue-500/50 transition-all h-full group flex flex-col">
    <!-- Header avec actions -->
    <div class="flex items-start justify-between mb-3">
        <h4 class="text-base font-semibold text-white flex-1">{{ $sprint->name }}</h4>
        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">
            @can('update', $sprint)
                <button wire:click="editSprint({{ $sprint->id }})"
                    class="p-1.5 hover:bg-gray-700 rounded-lg text-yellow-500 transition"
                    title="Modifier le sprint">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            @endcan
            @can('delete', $sprint)
                <button wire:click="confirmDeleteSprint({{ $sprint->id }})"
                    class="p-1.5 hover:bg-gray-700 rounded-lg text-orange-500 transition"
                    title="Supprimer le sprint">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            @endcan
        </div>
    </div>

    <!-- Dates -->
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span class="text-xs">{{ $sprint->start_date->format('d/m') }} → {{ $sprint->end_date->format('d/m') }}</span>
    </div>

    <!-- Informations -->
    <div class="space-y-2 flex-1">
        <!-- Durée totale -->
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">Durée totale</span>
            <span class="text-xs font-semibold text-white">{{ $duration }} jours</span>
        </div>

        <!-- Jours restants (seulement si en cours) -->
        @if($isActive)
        <div class="flex items-center justify-between">
            <span class="text-xs text-gray-400">Jours restants</span>
            <span class="text-xs font-semibold text-blue-400">{{ $daysRemaining }} jour{{ $daysRemaining > 1 ? 's' : '' }}</span>
        </div>
        @endif
    </div>

    <!-- Statut en bas à gauche -->
    <div class="mt-3 pt-3">
        <span class="px-2 py-1 rounded-full text-xs font-semibold inline-block
            @if($isActive) bg-blue-500/20 text-blue-400
            @elseif($isPast) bg-gray-500/20 text-gray-400
            @else bg-yellow-500/20 text-yellow-400
            @endif">
            @if($isActive) En cours
            @elseif($isPast) Terminé
            @else À venir
            @endif
        </span>
    </div>
</div>
