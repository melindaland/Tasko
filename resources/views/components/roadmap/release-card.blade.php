@props(['release'])

@php
$statusColors = [
'planned' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-400', 'label' => 'Planifiée'],
'in_progress' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'label' => 'En cours'],
'released' => ['bg' => 'bg-green-500/20', 'text' => 'text-green-400', 'label' => 'Publiée'],
];

$status = $statusColors[$release->status] ?? $statusColors['planned'];
$isPast = \Carbon\Carbon::now()->gt($release->release_date);
@endphp

<div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700/50 p-4 hover:border-orange-500/50 transition-all h-full flex flex-col">
    <!-- Header avec statut -->
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center gap-2 flex-1 min-w-0">
            <h4 class="text-base font-semibold text-white truncate">{{ $release->name }}</h4>
            @if($release->version)
            <span class="px-2 py-0.5 bg-orange-500/20 text-orange-400 text-xs font-mono rounded flex-shrink-0">
                v{{ $release->version }}
            </span>
            @endif
        </div>
        <span class="px-2 py-1 rounded-full text-xs font-semibold flex-shrink-0 {{ $status['bg'] }} {{ $status['text'] }}">
            {{ $status['label'] }}
        </span>
    </div>

    <!-- Date -->
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span class="text-xs">{{ $release->release_date->format('d/m/Y') }}</span>
        @if($isPast && $release->status !== 'released')
        <span class="text-orange-400 text-xs font-semibold">(En retard)</span>
        @endif
    </div>

    <!-- Description scrollable -->
    @if($release->description)
    <div class="flex-1 overflow-y-auto">
        <p class="text-sm text-gray-400">{{ $release->description }}</p>
    </div>
    @endif
</div>
