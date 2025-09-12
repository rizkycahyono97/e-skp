<div class="relative overflow-x-auto shadow-md sm:rounded-lg rounded-lg">

    {{-- session --}}
    @if (session('success'))
        <div id="alert-3"
            class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            {{-- Ikon checklist --}}
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>

            {{-- Tombol Close --}}
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                onclick="document.getElementById('alert-3').style.display='none'" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif

    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-primary dark:border-gray-700">
        <thead class="text-xs text-slate-100 uppercase bg-primary dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($headers as $header)
                    <th scope="col"
                        class="px-6 py-3 {{ $loop->first ? 'w-1 whitespace-nowrap border-r' : ($loop->last ? 'w-1 whitespace-nowrap' : 'w-full border-r') }} border-gray-200 dark:border-gray-700">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    {{-- Loop semua kolom kecuali "Action" --}}
                    @foreach (collect($row)->except('actions') as $cell)
                        <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-700">
                            {{ $cell }}
                        </td>
                    @endforeach

                    {{-- Kolom Action --}}
                    @if (isset($row['actions']))
                        <td class="px-4 py-4">
                            <div class="flex justify-end space-x-2">
                                {!! $row['actions'] !!}
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        No data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
