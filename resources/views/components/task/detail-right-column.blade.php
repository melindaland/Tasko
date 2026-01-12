@props(['task', 'editMode', 'assigned_users', 'members', 'attachment'])

<div class="space-y-6">
    <!-- Assigné à -->
    <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700/50">
        <label class="block text-sm font-medium text-gray-400 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Assigné à
        </label>
        @if($editMode)
            <div class="space-y-3" x-data="{ selectedUsers: @entangle('assigned_users') }">
                <p class="text-xs text-gray-400 mb-2">Cliquez sur les membres pour les assigner</p>
                <div class="space-y-2">
                    @foreach($members as $member)
                        <div @click="
                            if (selectedUsers.includes({{ $member->id }})) {
                                selectedUsers = selectedUsers.filter(id => id !== {{ $member->id }});
                            } else {
                                selectedUsers.push({{ $member->id }});
                            }
                        "
                        :class="selectedUsers.includes({{ $member->id }}) ? 'bg-blue-500/20 border-blue-500' : 'bg-gray-800 border-gray-700'"
                        class="flex items-center gap-3 p-3 rounded-lg border hover:border-blue-500/50 transition cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-medium text-sm">{{ $member->name }}</div>
                                <div class="text-gray-400 text-xs">{{ $member->email }}</div>
                            </div>
                            <div x-show="selectedUsers.includes({{ $member->id }})" class="text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @if($task->assigned_users && count($task->assigned_users) > 0)
                <div class="space-y-2">
                    @foreach($members->whereIn('id', $task->assigned_users) as $member)
                        <div class="flex items-center gap-3 p-3 bg-gray-800 rounded-lg border border-gray-700 hover:border-blue-500/50 transition">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-medium">{{ $member->name }}</div>
                                <div class="text-gray-400 text-xs">{{ $member->email }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($task->assignedUser)
                <div class="flex items-center gap-3 p-3 bg-gray-800 rounded-lg border border-gray-700 hover:border-blue-500/50 transition">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg">
                        {{ substr($task->assignedUser->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="text-white font-medium">{{ $task->assignedUser->name }}</div>
                        <div class="text-gray-400 text-xs">{{ $task->assignedUser->email }}</div>
                    </div>
                </div>
            @else
                <div class="text-center py-4 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="text-sm">Non assigné</p>
                </div>
            @endif
        @endif
    </div>

    <!-- Pièces jointes -->
    <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700/50">
        <label class="block text-sm font-medium text-gray-400 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
            </svg>
            Documents ({{ $task->attachments ? count($task->attachments) : 0 }})
        </label>

        @if($task->attachments && count($task->attachments) > 0)
            <div class="space-y-2 mb-3">
                @foreach($task->attachments as $index => $file)
                    <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700 hover:border-blue-500/50 transition group">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-white text-sm truncate block">{{ $file['name'] }}</span>
                                @if(isset($file['uploaded_by']))
                                    <span class="text-gray-500 text-xs">Par {{ $file['uploaded_by_name'] ?? 'Utilisateur' }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            {{-- Bouton télécharger (visible pour tous) --}}
                            <a href="{{ route('task.download-attachment', ['task' => $task->id, 'index' => $index]) }}"
                               class="text-blue-400 hover:text-blue-300 transition"
                               title="Télécharger"
                               target="_blank">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>

                            {{-- Bouton supprimer (Chef de projet = tous, Membre = seulement ses fichiers) --}}
                            @php
                                $canDelete = false;
                                if (auth()->user()->role === 'project_manager' && $task->project->owner_id === auth()->id()) {
                                    $canDelete = true; // Chef de projet peut tout supprimer
                                } elseif (auth()->user()->role === 'student' && isset($file['uploaded_by']) && $file['uploaded_by'] === auth()->id()) {
                                    $canDelete = true; // Membre peut supprimer ses propres fichiers
                                }
                            @endphp

                            @if($canDelete)
                                <button wire:click="confirmDeleteAttachment({{ $index }})"
                                        class="text-orange-400 hover:text-orange-300 transition"
                                        title="Supprimer le document">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @can('update', $task)
            <div>
                <input type="file" wire:model="attachment" class="hidden" id="attachment-upload">
                <label for="attachment-upload" class="cursor-pointer flex items-center justify-center gap-2 w-full px-4 py-3 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white border-2 border-dashed border-gray-700 hover:border-blue-500/50 transition group">
                    <svg class="w-5 h-5 group-hover:text-blue-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium">Ajouter un document</span>
                </label>
                @if($attachment)
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-gray-400 p-2 bg-gray-900 rounded-lg">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-blue-400 font-medium">Fichier sélectionné :</span>
                            <span class="text-white truncate">{{ $attachment->getClientOriginalName() }}</span>
                        </div>
                        <button wire:click="uploadAttachment"
                                class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Téléverser le fichier
                        </button>
                    </div>
                @endif
            </div>
        @endcan
    </div>
</div>
