<x-layouts.app>

    <x-partials.breadcrumbs :items="$breadcrumbs" />

    {{-- flash session --}}
    @if (session('error'))
        <x-partials.alert type="error" :message="session('error')" />
    @elseif (session('success'))
        <x-partials.alert type="success" :message="session('success')" />
    @endif

    @if ($performanceAgreement->status === 'reverted')
        <div
            class="max-w-5xl mx-auto mt-6 p-4 border-l-4 border-yellow-500 bg-yellow-100 dark:bg-yellow-800/30 text-yellow-800 dark:text-yellow-300 rounded-r-lg mb-5">
            <h4 class="font-bold">Dikembalikan untuk Revisi</h4>
            <p class="mt-1 text-sm">Atasan Anda memberikan catatan berikut. Silakan edit perjanjian ini dan ajukan
                kembali.</p>
            <blockquote class="mt-2 pl-3 border-l-2 border-yellow-600 italic text-sm">
                "{{ $performanceAgreement->rejection_reason }}"
            </blockquote>
        </div>
    @endif
    @if ($performanceAgreement->status === 'submitted')
        <div
            class="max-w-5xl mx-auto mt-6 p-4 border-l-4 border-blue-500 bg-blue-100 dark:bg-blue-800/30 text-blue-800 dark:text-blue-300 rounded-r-lg mb-5">
            <h4 class="font-bold">Menunggu Persetujuan</h4>
            <p class="mt-1 text-sm">
                Telah diajukan pada
                {{ $performanceAgreement->submitted_at ? $performanceAgreement->submitted_at->format('Y-m-d') : '-' }}
                dan sedang menunggu persetujuan dari atasan.
            </p>
        </div>
    @endif
    @if ($performanceAgreement->status === 'approved')
        <div
            class="max-w-5xl mx-auto mt-6 p-4 border-l-4 border-green-500 bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-300 rounded-r-lg mb-5">
            <h4 class="font-bold">Perjanjian Kerja Telah Disetujui</h4>
            <p class="mt-1 text-sm">Telah disetujui pada
                {{ $performanceAgreement->approved_at ? $performanceAgreement->approved_at->format('Y-m-d') : 'null' }}
                dan
                tidak dapat diubah lagi.</p>
        </div>
    @endif

    <x-partials.header title="{{ $performanceAgreement->title }}" description="Detail Perjanjian Kerja">

        <x-slot name="actions">
            <div class="flex items-center space-x-3">
                {{-- Tombol-tombol ini hanya muncul jika PA masih bisa diedit/diajukan --}}
                @if (in_array($performanceAgreement->status, ['draft', 'reverted']))
                    <a href="{{ route('performance-agreements.edit', $performanceAgreement->id) }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        Edit
                    </a>

                    {{-- Tombol "Ajukan" berada di dalam formnya sendiri untuk memicu aksi 'submit' --}}
                    <form method="POST"
                        action="{{ route('performance-agreements.persetujuan.submit', $performanceAgreement->id) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin mengajukan Perjanjian Kinerja dari {{ $performanceAgreement->cascaded_from }} ini untuk persetujuan?');">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Minta Persetujuan
                        </button>
                    </form>
                @else
                    <a href="{{ route('performance-agreements.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                        Kembali ke Daftar
                    </a>
                @endif
            </div>
        </x-slot>
    </x-partials.header>


    {{-- table utama --}}
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
                @forelse ($performanceAgreement->workResults as $workResult)

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
                                    <a href="{{ route('work-cascading.pa-create', $indicator->id) }}">
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
