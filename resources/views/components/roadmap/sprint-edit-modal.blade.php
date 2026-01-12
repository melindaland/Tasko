@props(['show', 'sprint', 'sprintName', 'sprintStartDate', 'sprintEndDate'])

@if($show && $sprint)
<div class="fixed inset-0 overflow-y-auto modal-backdrop" style="z-index: 10000;">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeEditSprintModal"></div>

        <div class="relative bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700 modal-content">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-white">Modifier le Sprint</h3>
                <button wire:click="closeEditSprintModal" type="button" class="text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="updateSprint">
                <div class="mb-4">
                    <label for="sprint_name" class="block text-sm font-medium mb-2">Nom du Sprint <span class="text-red-500">*</span></label>
                    <input type="text" id="sprint_name" wire:model="sprintName" required
                           class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
                    @error('sprintName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="sprint_start_date" class="block text-sm font-medium mb-2">Date de début <span class="text-red-500">*</span></label>
                        <input type="date" id="sprint_start_date" wire:model="sprintStartDate" required
                               class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
                        @error('sprintStartDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="sprint_end_date" class="block text-sm font-medium mb-2">Date de fin <span class="text-red-500">*</span></label>
                        <input type="date" id="sprint_end_date" wire:model="sprintEndDate" required
                               class="w-full px-4 py-2 bg-gray-900 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
                        @error('sprintEndDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" wire:click="closeEditSprintModal"
                            class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600">
                        Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
