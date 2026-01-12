@props(['show', 'epic', 'epicName', 'epicColor'])

@if($show && $epic)
<div class="fixed inset-0 z-50 overflow-y-auto modal-backdrop" style="z-index: 10000;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeEditEpicModal"></div>

        <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700 modal-content">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-white">Modifier l'Epic</h3>
                <button wire:click="closeEditEpicModal" type="button" class="text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="updateEpic">
                <div class="mb-4">
                    <label for="epicName" class="block text-sm font-medium mb-2">Nom de l'Epic *</label>
                    <input type="text" id="epicName" wire:model="epicName" required
                           class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white"
                           placeholder="Nom de l'epic">
                    @error('epicName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Couleur</label>

                    <div class="flex items-center gap-3 p-3 bg-gray-900 rounded-lg border border-gray-700">
                        <label for="customColorEdit" class="text-sm text-gray-400">Choisir une couleur :</label>
                        <div class="flex items-center gap-2">
                            <input type="color"
                                   id="customColorEdit"
                                   wire:model.live="epicColor"
                                   class="w-12 h-10 rounded cursor-pointer border-2 border-gray-600 bg-transparent">
                            <input type="text"
                                   wire:model.live="epicColor"
                                   placeholder="#3B82F6"
                                   class="w-28 px-3 py-2 bg-gray-800 border border-gray-600 rounded text-white text-sm focus:outline-none focus:border-purple-500">
                        </div>
                    </div>

                    @error('epicColor') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3">
                    <button type="button" wire:click="closeEditEpicModal"
                            class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
