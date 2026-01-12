@props(['project', 'activeTab'])

<aside x-data="{ open: true }"
       :class="open ? 'w-64 px-6' : 'w-20 px-3'"
       class="bg-gray-800 py-10 flex flex-col h-screen sticky top-0 transition-all duration-500 relative border-r border-white/10 z-0">

    <!-- Toggle Button -->
    <button @click="open = !open"
            class="absolute right-3 top-3 flex items-center justify-center px-4 py-3 hover:bg-white/5 rounded-md transition-colors">
        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div class="mt-14"></div>

    <!-- User Avatar -->
    <div x-show="open" x-transition class="w-14 h-14 mx-auto mb-10 rounded-full bg-blue-500 flex items-center justify-center text-2xl font-bold text-white shadow-lg select-none">
        {{ substr(Auth::user()->name, 0, 1) }}
    </div>

    <!-- Navigation -->
    <nav class="flex flex-col gap-3 w-full mt-4">
        <a href="{{ route('projects.dashboard', $project->id) }}"
           :class="'{{ $activeTab }}' === 'dashboard' ? 'bg-blue-500/10 text-blue-500' : 'text-white/70'"
           class="flex items-center gap-4 px-4 py-3 font-medium rounded-md hover:bg-white/5 transition-all"
           :title="!open ? 'Dashboard' : ''">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9v9a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <span x-show="open" x-transition>Dashboard</span>
        </a>

        <a href="{{ route('projects.kanban', $project->id) }}"
           :class="'{{ $activeTab }}' === 'kanban' ? 'bg-blue-500/10 text-blue-500' : 'text-white/70'"
           class="flex items-center gap-4 px-4 py-3 font-medium rounded-md hover:bg-white/5 transition-all"
           :title="!open ? 'Kanban' : ''">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <rect x="4" y="4" width="7" height="7" rx="1" stroke-width="2" />
                <rect x="13" y="4" width="7" height="7" rx="1" stroke-width="2" />
                <rect x="4" y="13" width="7" height="7" rx="1" stroke-width="2" />
                <rect x="13" y="13" width="7" height="7" rx="1" stroke-width="2" />
            </svg>
            <span x-show="open" x-transition>Kanban</span>
        </a>

        <a href="{{ route('projects.roadmap', $project->id) }}"
           :class="'{{ $activeTab }}' === 'roadmap' ? 'bg-blue-500/10 text-blue-500' : 'text-white/70'"
           class="flex items-center gap-4 px-4 py-3 font-medium rounded-md hover:bg-white/5 transition-all"
           :title="!open ? 'Roadmap' : ''">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 2l6 2 6-2v20l-6 2-6-2-6 2V2z" />
            </svg>
            <span x-show="open" x-transition>Roadmap</span>
        </a>
    </nav>

    <div class="flex-1"></div>

    <!-- Actions du bas -->
    <div class="w-full pt-4 border-t border-white/10">
        <a href="{{ route('workspace') }}"
           class="flex items-center gap-4 px-4 py-3 font-medium rounded-md hover:bg-white/5 transition-all w-full text-white/70"
           :class="open ? 'justify-start' : 'justify-center'"
           :title="!open ? 'Retour' : ''">
            <svg class="h-6 w-6 shrink-0 text-white/70" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M10 19l-7-7 7-7M3 12h18" />
            </svg>
            <span x-show="open" x-transition>Retour</span>
        </a>
    </div>
</aside>
