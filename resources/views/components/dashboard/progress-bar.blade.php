@props(['completedTasks', 'inProgressTasks', 'todoTasks', 'totalTasks'])

<div class="relative h-2 sm:h-3 bg-gray-700/50 rounded-full overflow-hidden">
    <div class="absolute inset-0 flex">
        @if($totalTasks > 0)
            <div class="bg-gradient-primary h-full transition-all duration-500"
                 style="width: {{ ($completedTasks / $totalTasks) * 100 }}%"></div>
            <div class="bg-gradient-primary h-full transition-all duration-500"
                 style="width: {{ ($inProgressTasks / $totalTasks) * 100 }}%"></div>
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 h-full transition-all duration-500"
                 style="width: {{ ($todoTasks / $totalTasks) * 100 }}%"></div>
        @else
            <div class="w-full h-full bg-gray-700"></div>
        @endif
    </div>
</div>
