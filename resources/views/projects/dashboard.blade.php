<x-layout.project title="Dashboard - {{ $project->name }}" :project="$project" activeTab="dashboard">
    <div class="max-w-7xl mx-auto overflow-x-hidden">
        @if (session('success'))
        <div class="mb-6 bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

                <div class="w-full sm:w-auto">
                    <h1 class="text-6xl font-bold text-white mb-6">{{ $project->name }}</h1>

                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 mt-4">

                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            Code <span class="font-mono text-blue-300 font-thin">{{ $project->access_code }}</span>
                        </span>

                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            Créé par <span class="text-blue-300 font-medium ml-1">{{ $project->owner->name }}</span>
                        </span>

                        @livewire('project.status-button', ['project' => $project], key('status-button-'.$project->id))

                    </div>
                </div>

                <div class="flex flex-wrap gap-2 flex-shrink-0 mt-2 sm:mt-0">
                    @can('update', $project)
                    @livewire('project.edit-modal', ['project' => $project], key('edit-project-dashboard-'.$project->id))
                    @endcan

                    @can('delete', $project)
                    @livewire('project.delete-modal', ['project' => $project], key('delete-project-dashboard-'.$project->id))
                    @endcan

                    @can('leave', $project)
                    @livewire('project.leave-modal', ['project' => $project], key('leave-project-dashboard-'.$project->id))
                    @endcan
                </div>
            </div>

        </div>



        @php
        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->where('status', 'done')->count();
        $inProgressTasks = $project->tasks->where('status', 'in_progress')->count();
        $todoTasks = $project->tasks->where('status', 'todo')->count();
        $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mt-10">
            <x-dashboard.stats-card title="Description">
                <p class="text-gray-400 text-sm line-clamp-3">{{ $project->description }}</p>
            </x-dashboard.stats-card>

            <x-dashboard.stats-card title="Membres">
                <x-slot:icon>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </x-slot:icon>
                <p class="text-2xl sm:text-3xl font-bold text-blue-500">{{ $project->members->count() + 1 }}</p>
                <p class="text-gray-400 text-xs sm:text-sm mt-1">Collaborateurs actifs</p>
            </x-dashboard.stats-card>

            <x-dashboard.stats-card title="Avancement">
                <x-slot:icon>
                    <div class="text-xl sm:text-2xl font-bold text-blue-500">{{ $progressPercentage }}%</div>
                </x-slot:icon>
                <x-dashboard.progress-bar
                    :completedTasks="$completedTasks"
                    :inProgressTasks="$inProgressTasks"
                    :todoTasks="$todoTasks"
                    :totalTasks="$totalTasks" />
                <p class="text-gray-400 text-xs sm:text-sm mt-6">{{ $completedTasks }} / {{ $totalTasks }} tâches terminées</p>
            </x-dashboard.stats-card>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-6 mt-8 sm:mb-8">
            @livewire('epic.create-modal', ['project' => $project], key('create-epic-'.$project->id))
            @livewire('sprint.create-modal', ['project' => $project], key('create-sprint-'.$project->id))
        </div>

        <div class="mt-6 sm:mt-10">
            <h2 class="text-xl sm:text-2xl font-bold text-white mb-4 sm:mb-6">Reporting</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">

                <div class="lg:col-span-2 bg-gray-800 p-4 sm:p-6 rounded-lg border border-gray-700 flex flex-col">
                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">Courbe d'avancement</h3>
                    <div class="flex-1 min-h-[250px] sm:min-h-[300px] lg:min-h-[400px]">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-gray-800 p-4 sm:p-6 rounded-lg border border-gray-700 flex flex-col">
                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4 text-center">Répartition par statut</h3>
                    <div class="flex-1 min-h-[250px] sm:min-h-[300px] lg:min-h-[400px] flex items-center justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/dashboard-charts.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CORRECTION APPLIQUÉE ICI : Utilisation d'une seule paire d'accolades et de virgules.
            initDashboardCharts(
                {{ $totalTasks }},
                {{ $completedTasks }},
                {{ $inProgressTasks }},
                {{ $todoTasks }},
            );
        });
    </script>
    @endpush
</x-layout.project>
