@props(['title', 'project', 'activeTab'])

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tasko' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-backdrop {
            animation: fadeIn 0.2s ease-out;
            z-index: 99999 !important;
        }
        .modal-content {
            animation: scaleIn 0.2s ease-out;
            z-index: 100000 !important;
        }
    </style>
</head>

<body class="bg-gray-950 text-white font-sans min-h-screen flex flex-col overflow-x-hidden">
    <!-- Header -->
    <header class="bg-gray-950 shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <a href="{{ route('workspace') }}" class="text-2xl font-bold text-white hover:text-blue-500 transition">
                Tasko
            </a>

            <div class="flex items-center gap-6">
                <button class="relative hover:text-blue-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 rounded-full w-2.5 h-2.5"></span>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="bg-blue-500 text-gray-900 font-bold rounded-full w-9 h-9 flex items-center justify-center uppercase hover:bg-blue-500/90 transition">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-40 bg-white text-gray-900 rounded-lg shadow-lg">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-200 transition-colors rounded-t-lg">Mon profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200 transition-colors rounded-b-lg">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="fixed top-20 right-4 z-[9999] space-y-2"
        x-data="{
            notifications: [],
            addNotification(data, type = 'success') {
                let message = typeof data === 'string' ? data : (data?.message || data?.toString() || '');
                if (!message || message.trim() === '') return;
                const id = Date.now();
                this.notifications.push({ id, message, type });
                setTimeout(() => {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }, 4000);
            }
         }"
        @flash-success.window="addNotification($event.detail, 'success')"
        @flash-error.window="addNotification($event.detail, 'error')"
        @flash-warning.window="addNotification($event.detail, 'warning')"
        @flash-info.window="addNotification($event.detail, 'info')"
        @flash-message.window="addNotification($event.detail, 'success')">

        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full"
                :class="{
                    'bg-green-600': notification.type === 'success',
                    'bg-red-600': notification.type === 'error',
                    'bg-yellow-600': notification.type === 'warning',
                    'bg-blue-600': notification.type === 'info'
                 }"
                class="text-white px-6 py-3 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px]">

                <!-- Icon Success -->
                <svg x-show="notification.type === 'success'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>

                <!-- Icon Error -->
                <svg x-show="notification.type === 'error'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>

                <!-- Icon Warning -->
                <svg x-show="notification.type === 'warning'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>

                <!-- Icon Info -->
                <svg x-show="notification.type === 'info'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span x-text="notification.message" class="flex-1"></span>

                <button @click="notifications = notifications.filter(n => n.id !== notification.id)"
                    class="text-white/80 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <!-- Main Content Area -->
    <div class="flex flex-grow bg-gray-900 text-white">
        <!-- Sidebar Component -->
        <x-sidebar :project="$project" :activeTab="$activeTab" />

        <!-- Main Content -->
        <div class="flex-1 py-10 px-6 md:px-8 bg-gray-900 relative z-0">
            {{ $slot }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-950 py-6 text-center text-white">
        <p>&copy; 2025 Tasko. Tous droits réservés.</p>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>

</html>
