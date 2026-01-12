<div>
    <button wire:click="openModal" type="button"
        class="flex items-center gap-2 px-3 sm:px-4 py-2 bg-orange-500 text-white px-4 py-2 rounded-full hover:bg-orange-500/90 transition-all"
        title="Supprimer le projet">
        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        <span class="text-xs sm:text-sm font-medium hidden sm:inline">Supprimer</span>
    </button>

    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto modal-backdrop">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700/50 modal-content">
                <div class="flex justify-center mb-4">
                    <div class="bg-orange-500/10 p-4 rounded-full">
                        <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-white text-center mb-2">Supprimer le projet</h3>
                <p class="text-gray-400 text-center mb-6">
                    Êtes-vous sûr de vouloir supprimer le projet "<span class="font-bold text-white">{{ $project->name }}</span>" ? Cette action est irréversible.
                </p>

                <div class="flex gap-3">
                    <button type="button" wire:click="closeModal"
                        class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="button" wire:click="deleteProject"
                        class="flex-1 px-6 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
