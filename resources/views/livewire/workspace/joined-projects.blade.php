<div class="mb-12">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-white mb-4 sm:mb-0">Projets rejoints</h2>
        @livewire('project.join-modal')
    </div>

    @if($projects->isEmpty())
    <div class="bg-gray-800/50 backdrop-blur-sm p-8 md:p-16 rounded-2xl border border-gray-700/50 text-center">
        <div class="bg-orange-500/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <p class="text-gray-300 text-xl font-semibold mb-2">Aucun projet rejoint</p>
        <p class="text-gray-500 text-sm">Rejoignez un projet avec un code d'accès</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
        <a href="{{ route('projects.dashboard', $project->id) }}" class="group bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700/50 hover:border-orange-500/50 hover:bg-gray-800/70 transition-all duration-300 cursor-pointer block">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-xl font-bold text-white group-hover:text-orange-400 transition-colors">{{ $project->name }}</h3>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ in_array($project->status, ['termine', 'archive']) ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-orange-500/10 text-orange-400 border border-orange-500/20' }}">
                    {{ in_array($project->status, ['termine', 'archive']) ? 'Terminé' : 'En cours' }}
                </span>
            </div>

            <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                {{ $project->description ?? 'Aucune description' }}
            </p>

            <div class="flex items-center justify-between text-sm pt-4 border-t border-gray-700/50">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Par {{ $project->owner->name }}</span>
                </div>
                <span class="text-gray-500">{{ $project->created_at->diffForHumans() }}</span>
            </div>
        </a>
        @endforeach
    </div>
    @endif
</div>
