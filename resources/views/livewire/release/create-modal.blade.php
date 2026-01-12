<div>
    <!-- Bouton d'ouverture -->
    <button wire:click="openModal"
        class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nouvelle Release
    </button>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm modal-backdrop"
        x-data
        x-init="$el.focus()"
        @keydown.escape.window="$wire.closeModal()">

        <div class="bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 border border-gray-700 modal-content"
            @click.stop>

            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-700">
                <h3 class="text-2xl font-bold text-white">Créer une Release</h3>
                <button wire:click="closeModal"
                    class="text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <form wire:submit.prevent="save" class="p-6 space-y-4">
                <!-- Nom -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Nom de la release <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        wire:model="name"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ex: Version majeure Q1">
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Version -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Version
                    </label>
                    <input type="text"
                        wire:model="version"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Ex: 2.0.0">
                    @error('version')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de release -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Date de release <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                        wire:model="release_date"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('release_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="status"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="planned">Planifiée</option>
                        <option value="in_progress">En cours</option>
                        <option value="released">Publiée</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea wire:model="description"
                        rows="3"
                        class="w-full px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"
                        placeholder="Décrivez les fonctionnalités de cette release..."></textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                        wire:click="closeModal"
                        class="px-4 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600 transition">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition">
                        Créer la Release
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
