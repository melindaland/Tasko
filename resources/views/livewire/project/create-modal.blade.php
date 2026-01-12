<div>
    <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-500/90 transition flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nouveau projet
    </button>

    <!-- Modal de création -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto modal-backdrop">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700 modal-content">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Créer un projet</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="createProject">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium mb-2">Nom du projet <span class="text-red-500">*</span></label>
                        <input type="text" id="name" wire:model="name"
                               class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium mb-2">Description <span class="text-red-500">*</span></label>
                        <textarea id="description" wire:model="description" rows="3" required
                                  class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium mb-2">Date de début</label>
                            <input type="date" id="start_date" wire:model="start_date"
                                   class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium mb-2">Date de fin</label>
                            <input type="date" id="end_date" wire:model="end_date"
                                   class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 transition text-white">
                        </div>
                    </div>

                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <div class="flex gap-3">
                        <button type="button" wire:click="closeModal"
                                class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600 transition">
                            Annuler
                        </button>
                        <button type="submit"
                                class="flex-1 px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-500/90 transition">
                            Créer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de succès avec code d'accès -->
    @if($showSuccessModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ copied: false }">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

            <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-8 border border-gray-700">
                <!-- Icône de succès -->
                <div class="flex justify-center mb-6">
                    <div class="bg-orange-500/10 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-white text-center mb-2">Projet créé !</h3>
                <p class="text-gray-400 text-center mb-6">Le projet "{{ $projectName }}" a été créé avec succès</p>

                <!-- Code d'accès -->
                <div class="bg-gray-900 p-6 rounded-lg border border-gray-700 mb-6">
                    <p class="text-gray-400 text-sm text-center mb-3">Voici le code d'accès :</p>
                    <div class="flex items-center justify-center gap-3">
                        <p class="text-4xl font-bold text-blue-500 tracking-widest font-mono">{{ $accessCode }}</p>
                        <button
                            @click="navigator.clipboard.writeText('{{ $accessCode }}'); copied = true; setTimeout(() => copied = false, 2000)"
                            class="p-2 hover:bg-gray-800 rounded-lg transition"
                            title="Copier le code">
                            <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs text-center mt-3">Partagez ce code avec votre équipe pour qu'ils puissent rejoindre le projet</p>
                </div>

                <button wire:click="closeSuccessModal"
                        class="w-full px-6 py-3 bg-blue-500 text-white rounded-full hover:bg-blue-500/90 transition font-semibold">
                    Compris !
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
