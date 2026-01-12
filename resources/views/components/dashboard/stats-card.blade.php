@props(['title', 'icon' => null])

<div class="bg-gray-800 p-4 sm:p-6 rounded-lg border border-gray-700 hover:border-blue-500/50">
    @if($icon)
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-base sm:text-lg font-bold text-white">{{ $title }}</h3>
        {{ $icon }}
    </div>
    @else
    <h3 class="text-base sm:text-lg font-bold text-white mb-2">{{ $title }}</h3>
    @endif

    {{ $slot }}
</div>
