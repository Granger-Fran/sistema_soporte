<div class="flex items-center justify-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <div class="relative">
        <x-heroicon-o-bell class="w-6 h-6 text-gray-800 dark:text-white" />
        @if ($pendingCount > 0)
            <span
                class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                {{ $pendingCount }}
            </span>
        @endif
    </div>
</div>
