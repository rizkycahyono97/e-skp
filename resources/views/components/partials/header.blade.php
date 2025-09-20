{{-- resources/views/components/header.blade.php --}}
<div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $title }}</h1>
            @if ($description)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
            @endif
        </div>
        <div>
            {{ $actions ?? '' }}
        </div>
    </div>
</div>
