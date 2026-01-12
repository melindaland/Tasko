<x-layout.base title="Espace de travail">

    <div class="bg-gradient-primary w-full shadow-2xl mb-12">
        @livewire('workspace.project-stats')
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @livewire('workspace.owned-projects')

        @livewire('workspace.joined-projects')
    </div>
</x-layout.base>
