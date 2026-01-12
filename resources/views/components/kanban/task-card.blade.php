@props(['task'])

<div class="bg-gray-800 p-4 rounded-xl border-l-4 hover:shadow-lg transition-all cursor-move"
     style="border-left-color: {{ $task->epic?->color ?? '#6b7280' }}"
     wire:click="$dispatch('openTaskDetail', { taskId: {{ $task->id }} })"
     onclick="event.stopPropagation()">

    <!-- Titre -->
    <h4 class="font-semibold text-white mb-2">{{ $task->title }}</h4>

    <!-- Description -->
    @if($task->description)
        <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $task->description }}</p>
    @endif

    <!-- Epic badge -->
    @if($task->epic)
        <div class="mb-3">
            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium"
                  style="background-color: {{ $task->epic->color }}20; color: {{ $task->epic->color }}">
                <span class="w-2 h-2 rounded-full" style="background-color: {{ $task->epic->color }}"></span>
                {{ $task->epic->name }}
            </span>
        </div>
    @endif

    <!-- Footer -->
    <div class="flex items-center justify-between text-xs">
        <!-- Responsable -->
        <div class="flex items-center gap-2">
            @if($task->assignedUser)
                <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-xs">
                    {{ substr($task->assignedUser->name, 0, 1) }}
                </div>
                <span class="text-gray-400">{{ $task->assignedUser->name }}</span>
            @else
                <span class="text-gray-500">Non assigné</span>
            @endif
        </div>

        <!-- Date d'échéance -->
        @if($task->due_date)
            <span class="text-gray-400 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $task->due_date->format('d/m') }}
            </span>
        @endif
    </div>
</div>
