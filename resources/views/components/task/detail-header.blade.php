@props(['editMode', 'task'])

<div class="flex items-center justify-between p-6 border-b border-gray-700 bg-gray-800">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white">Détails de la tâche</h2>
    </div>
    <div class="flex items-center gap-2">
        @if($editMode)
            <button wire:click="updateTask" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                Enregistrer
            </button>
            <button wire:click="toggleEditMode" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                Annuler
            </button>
        @else
            @can('update', $task)
                <button wire:click="toggleEditMode" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Modifier
                </button>
            @endcan
            @can('delete', $task)
                <button wire:click="confirmDeleteTask" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                    Supprimer
                </button>
            @endcan
        @endif
        <button wire:click="closeModal" class="text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
