<div class="mb-12">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-white mb-4 sm:mb-0">Mes projets créés</h2>
        @livewire('project.create-modal')
    </div>

    @if($projects->isEmpty())
    <div class="bg-gray-800/50 backdrop-blur-sm p-8 md:p-16 rounded-2xl border border-gray-700/50 text-center">
        <div class="bg-blue-500/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
        </div>
        <p class="text-gray-300 text-xl font-semibold mb-2">Aucun projet créé</p>
        <p class="text-gray-500 text-sm">Créez votre premier projet pour commencer</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
        <a href="{{ route('projects.dashboard', $project->id) }}" class="group bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700/50 hover:border-blue-500/50 hover:bg-gray-800/70 transition-all duration-300 cursor-pointer block">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors">{{ $project->name }}</h3>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ in_array($project->status, ['termine', 'archive']) ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-blue-500/10 text-blue-400 border border-blue-500/20' }}">
                    {{ in_array($project->status, ['termine', 'archive']) ? 'Terminé' : 'En cours' }}
                </span>
            </div>

            <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                {{ $project->description ?? 'Aucune description' }}
            </p>

            <div class="flex items-center justify-between text-sm pt-4 border-t border-gray-700/50">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>{{ $project->members->count() }} membres</span>
                </div>
                <span class="text-gray-500">{{ $project->created_at->diffForHumans() }}</span>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
