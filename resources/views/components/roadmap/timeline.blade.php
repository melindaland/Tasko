@props(['sprints', 'tasks', 'month'])

<div class="mb-6 sm:mb-8">
    <!-- Header avec navigation -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-white flex items-center gap-2">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Timeline - {{ $month['label'] }}
        </h3>

        <div class="flex items-center gap-2">
            <button wire:click="previousMonth"
                    class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition text-white"
                    title="Mois précédent">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button wire:click="goToCurrentMonth"
                    class="px-3 py-2 bg-gradient-to-r from-blue-600 to-orange-500 hover:from-blue-700 hover:to-orange-600 text-white text-sm font-medium rounded-lg transition shadow-lg"
                    title="Revenir au mois actuel">
                Aujourd'hui
            </button>
            <button wire:click="nextMonth"
                    class="p-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition text-white"
                    title="Mois suivant">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl border border-gray-700/50 p-4">
        <!-- Calendrier du mois -->
        <div class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-orange-500/50 scrollbar-track-gray-800/50">
            <!-- En-tête des jours -->
            <div class="flex gap-0 min-w-max">
                @for($day = 1; $day <= $month['days']; $day++)
                    <div class="w-10 flex-shrink-0 border-r border-gray-700/30 text-center">
                        <div class="text-xs font-semibold text-white py-2">{{ $day }}</div>
                    </div>
                @endfor
            </div>

            <!-- Tâches par epic -->
            @if($tasks->isNotEmpty())
                <div class="relative mt-4 min-w-max">
                    @php
                        $tasksByEpic = $tasks->groupBy('epic_id');
                        $startDate = $month['startDate'];
                        $endDate = $month['endDate'];
                        $dayWidth = 40; // w-10 = 40px
                    @endphp

                    <div class="relative" style="min-height: 100px; width: {{ $month['days'] * $dayWidth }}px;">
                        @foreach($tasks as $task)
                            @php
                                if (!$task->due_date) continue;

                                $taskDate = $task->due_date->startOfDay();

                                // Vérifier si la tâche est dans le mois affiché
                                if ($taskDate->lt($startDate) || $taskDate->gt($endDate)) continue;

                                // Calculer la position en pixels
                                $dayOfMonth = $taskDate->day;
                                $leftPosition = ($dayOfMonth - 1) * $dayWidth;

                                // Couleur de l'epic ou gris par défaut
                                $epicColor = $task->epic ? $task->epic->color : '#6B7280';
                                $epicName = $task->epic ? $task->epic->name : 'Sans epic';
                            @endphp

                            <a href="{{ route('projects.kanban', ['project' => $task->project_id]) }}?task={{ $task->id }}"
                               class="absolute rounded px-2 py-1 hover:opacity-80 transition cursor-pointer group block"
                               style="left: {{ $leftPosition }}px; width: {{ $dayWidth }}px; background-color: {{ $epicColor }}; top: {{ ($loop->index % 5) * 40 }}px;"
                               title="{{ $task->title }} - {{ $task->due_date->format('d/m/Y') }} ({{ $epicName }})">
                                <span class="text-xs font-medium text-white truncate block">{{ substr($task->title, 0, 2) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p class="text-sm">Aucune tâche ce mois-ci</p>
                </div>
            @endif
        </div>
    </div>
</div>
