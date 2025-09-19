<div class="relative overflow-x-auto shadow-md sm:rounded-lg rounded-lg">

    {{-- flash session --}}
    @if (session('error'))
        <x-partials.alert type="error" :message="session('error')" />
    @elseif (session('success'))
        <x-partials.alert type="success" :message="session('success')" />
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
