@props(['showDeleteTaskModal', 'showDeleteFileModal', 'task', 'fileToDelete'])

<!-- Modal de suppression de tâche -->
@if($showDeleteTaskModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="z-index: 999999;">
    <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700/50">
        <div class="flex justify-center mb-4">
            <div class="bg-orange-500/10 p-4 rounded-full">
                <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-white text-center mb-2">Supprimer la tâche</h3>
        <p class="text-gray-400 text-center mb-6">
            Êtes-vous sûr de vouloir supprimer cette tâche ? Cette action est irréversible.
        </p>

        <div class="flex gap-3">
            <button wire:click="$set('showDeleteTaskModal', false)" class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                Annuler
            </button>
            <button wire:click="deleteTask" class="flex-1 px-6 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600">
                Supprimer
            </button>
        </div>
    </div>
</div>
@endif

<!-- Modal de suppression de fichier -->
@if($showDeleteFileModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="z-index: 999999;">
    <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 border border-gray-700/50">
        <div class="flex justify-center mb-4">
            <div class="bg-orange-500/10 p-4 rounded-full">
                <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-white text-center mb-2">Supprimer le fichier</h3>
        <p class="text-gray-400 text-center mb-6">
            Êtes-vous sûr de vouloir supprimer ce fichier ? Cette action est irréversible.
        </p>

        <div class="flex gap-3">
            <button wire:click="$set('showDeleteFileModal', false)" class="flex-1 px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600">
                Annuler
            </button>
            <button wire:click="deleteAttachment" class="flex-1 px-6 py-2 bg-orange-500 text-white rounded-full hover:bg-orange-600">
                Supprimer
            </button>
        </div>
    </div>
</div>
@endif
