<div class="max-w-7xl mx-auto overflow-x-hidden">
    <div class="max-w-7xl mx-auto -mx-6 md:-mx-8 h-full flex flex-col w-full">
        <div class="px-6 md:px-8 h-full flex flex-col flex-1 w-full">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6 flex-shrink-0">
                <div>
                    <h2 class="text-3xl font-bold text-white">Roadmap</h2>
                    <p class="text-gray-400 mt-1">Vue d'ensemble des sprints et releases</p>
                </div>

                <div class="flex gap-3">
                    @can('createContent', $project)
                        @livewire('sprint.create-modal', ['project' => $project], key('create-sprint-header-'.$project->id))
                        @livewire('release.create-modal', ['project' => $project], key('create-release-'.$project->id))
                    @endcan
                </div>
            </div>

            <!-- Timeline Container -->
            <div class="w-full">
        @if($sprints->isEmpty() && $releases->isEmpty())
            <div class="flex flex-col items-center justify-center h-full text-gray-500 py-20">
                <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 2l6 2 6-2v20l-6 2-6-2-6 2V2z" />
                </svg>
                <p class="text-xl font-semibold text-white">Aucune donnée de roadmap</p>
                <p class="text-sm mt-2 mb-6">Créez des sprints et des releases pour visualiser votre roadmap</p>

                @can('createContent', $project)
                    <div class="flex gap-3">
                        @livewire('sprint.create-modal', ['project' => $project], key('create-sprint-empty-'.$project->id))
                        @livewire('release.create-modal', ['project' => $project], key('create-release-empty-'.$project->id))
                    </div>
                @else
                    <p class="text-sm text-gray-400 mt-4">Vous n'avez pas les permissions pour créer des éléments dans ce projet.</p>
                @endcan
            </div>
        @else
            <!-- Sprints Section -->
            @if($sprints->isNotEmpty())
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Sprints
                    </h3>
                    <div class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-blue-500/50 scrollbar-track-gray-800/50">
                        <div class="flex gap-4 min-w-max">
                            @foreach($sprints as $sprint)
                                <div class="w-80 flex-shrink-0">
                                    <x-roadmap.sprint-card :sprint="$sprint" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Timeline visuelle -->
            @if($sprints->isNotEmpty() || $tasks->isNotEmpty())
                <x-roadmap.timeline
                    :sprints="$sprints"
                    :tasks="$tasks"
                    :month="$month" />
            @endif

            <!-- Releases Section -->
            @if($releases->isNotEmpty())
                <div>
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        Releases
                    </h3>
                    <div class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-orange-500/50 scrollbar-track-gray-800/50">
                        <div class="flex gap-4 min-w-max">
                            @foreach($releases as $release)
                                <div class="w-80 flex-shrink-0">
                                    <x-roadmap.release-card :release="$release" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif
            </div>
        </div>
    </div>

    <!-- Modales Sprint -->
    <x-roadmap.sprint-edit-modal
        :show="$showEditSprintModal"
        :sprint="$sprintToEdit"
        :sprintName="$sprintName"
        :sprintStartDate="$sprintStartDate"
        :sprintEndDate="$sprintEndDate" />

    <x-roadmap.sprint-delete-modal
        :show="$showDeleteSprintModal"
        :sprint="$sprintToDelete" />
</div>
