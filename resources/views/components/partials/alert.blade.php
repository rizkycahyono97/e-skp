@props([
    'type' => 'success',   {{-- default sukses --}}
    'message' => null,
])

@php
    $bgColor = [
        'success' => 'bg-green-100 text-green-800 dark:bg-gray-800 dark:text-green-400',
        'error'   => 'bg-red-100 text-red-800 dark:bg-gray-800 dark:text-red-400',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-gray-800 dark:text-yellow-400',
        'info'    => 'bg-blue-100 text-blue-800 dark:bg-gray-800 dark:text-blue-400',
    ][$type] ?? 'bg-gray-100 text-gray-800';
@endphp

@if ($message)
    <div id="alert-{{ $type }}"
        class="flex items-center p-4 mb-4 rounded-lg {{ $bgColor }}" role="alert">
        {{-- Ikon --}}
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>

        <div class="ms-3 text-sm font-medium">
            {{ $message }}
        </div>

        {{-- Tombol Close --}}
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 hover:opacity-80 inline-flex items-center justify-center h-8 w-8"
            onclick="this.parentElement.style.display='none'" aria-label="Close">
            <span class="sr-only">Close</span>
            ✖
        </button>
    </div>
@endif
