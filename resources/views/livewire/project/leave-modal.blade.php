<div>
    <button wire:click="openModal" type="button"
            class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-lg hover:bg-orange-500/10 text-orange-500 transition-all border border-orange-500/20 hover:border-orange-500/40"
            title="Quitter le projet">
        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span class="text-xs sm:text-sm font-medium hidden sm:inline">Quitter</span>
    </button>

    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto modal-backdrop">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700/50 modal-content">
                <div class="flex justify-center mb-4">
                    <div class="bg-orange-500/10 p-4 rounded-full">
                        <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-white text-center mb-2">Quitter le projet</h3>
                <p class="text-gray-400 text-center mb-6">
                    Êtes-vous sûr de vouloir quitter le projet "<span class="font-bold text-white">{{ $project->name }}</span>" ?
                </p>

                <div class="flex gap-3">
                    <button type="button" wire:click="closeModal"
                            class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" wire:click="leaveProject"
                            class="flex-1 px-6 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600">
                        Quitter
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
