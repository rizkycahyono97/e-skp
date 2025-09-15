<x-layouts.app>

    <x-partials.breadcrumbs :items="$breadcrumbs" />

    {{-- flash session --}}
    @if (session('error'))
        <x-partials.alert type="error" :message="session('error')" />
    @elseif (session('success'))
        <x-partials.alert type="success" :message="session('success')" />
    @endif


    <div
        class="max-w-5xl mx-auto mt-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-primary dark:bg-gray-700 text-left text-white dark:text-gray-300 uppercase text-xs">
                <tr>
                    <th class="border border-gray-200 dark:border-gray-600 px-4 py-3 w-3/4">Hasil Kerja</th>
                    <th class="border border-gray-200 dark:border-gray-600 px-4 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 dark:text-gray-300">
                @forelse ($pa->workResults as $workResult)

                    {{-- Work Result --}}
                    <tr class="border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-4 py-3 border-r border-gray-200 dark:border-gray-700">
                            <span class="font-semibold mr-2">{{ $loop->iteration }}.</span>
                            <span class="font-semibold">{{ $workResult->description }}</span>
                            <span class="text-xs text-gray-500">(table work result)</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- <a href="{{ route('work-cascading.create', $workResult->id) }}">
                                    <button
                                        class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Cascading</button>
                                </a> --}}

                            </div>
                        </td>
                    </tr>

                    {{-- Indicators --}}
                    @foreach ($workResult->indicators as $indicator)
                        <tr
                            class="border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-8 py-2 border-r border-gray-200 dark:border-gray-700">
                                <span class="mr-2">-</span>
                                {{ $indicator->description }}
                                <span class="text-xs text-gray-500">(table indicators)</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('work-cascading.create', $indicator->id) }}">
                                        <button
                                            class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Cascading</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                @empty
                    <tr>
                        <td colspan="2" class="text-center py-6 text-gray-500">
                            Tidak ada data hasil kerja yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
