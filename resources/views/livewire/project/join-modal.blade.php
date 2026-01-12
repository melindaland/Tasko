<div>
    <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-500/90 transition flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        Rejoindre un projet
    </button>

    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto modal-backdrop" x-data="{ show: @entangle('showModal') }">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700 modal-content">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-white">Rejoindre un projet</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="joinProject">
                    <div class="mb-6">
                        <label for="access_code" class="block text-sm font-medium mb-2">Code d'accès (6 chiffres) <span class="text-red-500">*</span></label>
                        <input type="text" id="access_code" wire:model="access_code" maxlength="6" placeholder="000000"
                               class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-amber-500 transition text-white text-center text-2xl tracking-widest font-mono">
                        @error('access_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <p class="text-gray-400 text-sm mt-2">
                            Entrez le code d'accès fourni par le créateur du projet
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" wire:click="closeModal"
                                class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600 transition">
                            Annuler
                        </button>
                        <button type="submit"
                                class="flex-1 px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-500/90 transition">
                            Rejoindre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
