<div>
    <button wire:click="openModal" type="button"
        class="flex items-center gap-2 px-3 sm:px-4 py-2 bg-yellow-500 text-white px-4 py-2 rounded-full hover:bg-yellow-500/90 transition-all"
        title="Modifier le projet">
        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span class="text-xs sm:text-sm font-medium hidden sm:inline">Modifier</span>
    </button>

    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto modal-backdrop">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700 modal-content">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Modifier le projet</h3>
                    <button wire:click="closeModal" type="button" class="text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="updateProject">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Nom du projet <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="name" required
                            class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Description <span class="text-red-500">*</span></label>
                        <textarea wire:model="description" rows="3" required
                            class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">Date début</label>
                            <input type="date" wire:model="start_date"
                                class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Date fin</label>
                            <input type="date" wire:model="end_date"
                                class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                            Annuler
                        </button>
                        <button type="submit"
                            class="flex-1 px-6 py-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-500/90 ">
                            Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
