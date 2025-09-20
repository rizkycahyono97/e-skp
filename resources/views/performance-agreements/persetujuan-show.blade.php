<x-layouts.app>
    <div x-data="{ isModalOpen: false }">
        {{-- <x-partials.breadcrumbs :items="$breadcrumbs" /> --}}

        <div class="max-w-7xl mx-auto mt-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Kolom Kiri: Detail Konten PA --}}
                <div class="lg:col-span-2 space-y-6">
                    <x-partials.header title="{{ $performanceAgreement->title }}"
                        description="Tahun: {{ $performanceAgreement->year }}" />

                    {{-- Daftar Hasil Kerja dan Indikator --}}
                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Rincian Hasil Kerja
                            </h2>
                            <div class="space-y-5">
                                @forelse ($performanceAgreement->workResults as $workResult)
                                    <div
                                        class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0 last:pb-0">
                                        {{-- Deskripsi Hasil Kerja --}}
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">
                                            <span class="mr-2">{{ $loop->iteration }}.</span>
                                            {{ $workResult->description }}
                                        </p>
                                        {{-- Daftar Indikator --}}
                                        <ul
                                            class="mt-2 ml-8 space-y-1 list-disc list-inside text-sm text-gray-600 dark:text-gray-400">
                                            @forelse ($workResult->indicators as $indicator)
                                                <li>{{ $indicator->description }}</li>
                                            @empty
                                                <li class="text-gray-400 italic">Tidak ada indikator untuk hasil kerja
                                                    ini.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                @empty
                                    <p class="text-center py-6 text-gray-500">Tidak ada data hasil kerja yang ditemukan.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Panel Aksi --}}
                <div class="lg:sticky top-6 h-fit">
                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Tindakan Persetujuan</h3>
                            <div class="mt-4 space-y-3 text-sm border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Pengaju:</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $performanceAgreement->user->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Unit Kerja:</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ $performanceAgreement->user->unit->unit_name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500 dark:text-gray-400">Tgl. Diajukan:</span>
                                    <span
                                        class="font-medium text-gray-800 dark:text-gray-200">{{ optional($performanceAgreement->submitted_at)->format('d M Y') }}</span>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-6 space-y-3">
                                <form method="POST"
                                    action="{{ route('performance-agreements.persetujuan.approve', $performanceAgreement->id) }}"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menyetujui Perjanjian Kinerja ini?');">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg text-sm font-medium">
                                        Setujui
                                    </button>
                                </form>
                                <button @click="isModalOpen = true" type="button"
                                    class="w-full text-white bg-yellow-500 hover:bg-yellow-600 px-5 py-2.5 rounded-lg text-sm font-medium">
                                    Kembalikan untuk Revisi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Modal untuk Form "Kembalikan/Tolak" --}}
        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
            <div @click.away="isModalOpen = false"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg mx-4">
                <form method="POST"
                    action="{{ route('performance-agreements.persetujuan.revert', $performanceAgreement->id) }}">
                    @csrf
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Alasan Pengembalian</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Berikan catatan agar bawahan Anda dapat
                            melakukan perbaikan yang diperlukan.</p>
                        <div class="mt-4">
                            <textarea name="rejection_reason" rows="4"
                                class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm"
                                placeholder="Contoh: Mohon tambahkan indikator kuantitatif untuk hasil kerja nomor 2..." required></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3 rounded-b-lg">
                        <button @click="isModalOpen = false" type="button"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                            Kirim Catatan & Kembalikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
