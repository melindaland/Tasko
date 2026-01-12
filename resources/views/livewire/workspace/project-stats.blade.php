<section class="w-full flex items-center justify-center m-0 py-12 md:py-16 relative overflow-hidden shadow-2xl">

    <div class="w-full max-w-6xl text-center relative z-10 px-4 sm:px-6">

        <h1 class="text-5xl md:text-6xl font-bold text-white mb-3 tracking-tight">
            Bonjour, {{ Auth::user()->name }}
        </h1>
        <p class="text-white/90 font-medium text-xl md:text-2xl mb-10 md:mb-12">
            Bienvenue sur ton espace de travail
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-black/20 backdrop-blur-lg border border-white/20 p-6 rounded-2xl hover:bg-black/30 transition-all duration-300">
                <div class="flex justify-center mb-3">
                    <div class="bg-blue-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white mb-1">{{ $totalProjects }}</p>
                <p class="text-white/80 text-sm font-medium">Projets totaux</p>
            </div>

            <div class="bg-black/20 backdrop-blur-lg border border-white/20 p-6 rounded-2xl hover:bg-black/30 transition-all duration-300">
                <div class="flex justify-center mb-3">
                    <div class="bg-orange-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white mb-1">{{ $createdProjects }}</p>
                <p class="text-white/80 text-sm font-medium">Projets créés</p>
            </div>

            <div class="bg-black/20 backdrop-blur-lg border border-white/20 p-6 rounded-2xl hover:bg-black/30 transition-all duration-300">
                <div class="flex justify-center mb-3">
                    <div class="bg-yellow-500/20 p-3 rounded-xl">
                        <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white mb-1">{{ $finishedProjects }}</p>
                <p class="text-white/80 text-sm font-medium">Projets terminés</p>
            </div>
        </div>
    </div>
</section>
