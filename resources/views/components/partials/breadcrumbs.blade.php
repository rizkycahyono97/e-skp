{{-- resources/views/components/breadcrumbs.blade.php --}}
<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        @foreach ($items as $item)
            <li class="@if (!$loop->first) flex items-center @endif">
                @if (!$loop->first)
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                @endif

                @if ($item['url'])
                    <a href="{{ $item['url'] }}"
                        class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">{{ $item['name'] }}</a>
                @else
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $item['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
