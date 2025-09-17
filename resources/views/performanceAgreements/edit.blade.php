<x-layouts.app>

    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <style>
        .fade-enter {
            opacity: 0;
            transform: translateY(-10px);
        }

        .fade-enter-active {
            transition: opacity 300ms, transform 300ms;
        }

        .slide-enter {
            max-height: 0;
            overflow: hidden;
        }

        .slide-enter-active {
            transition: max-height 300ms ease-out;
        }
    </style>

    <div class="bg-gray-50 dark:bg-gray-800 font-sans" x-data="workResultEditor">
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Perjanjian Kerja</h1>
                <p class="text-gray-600 mt-2 dark:text-slate-300">Edit Perjanjian Kerja, Hasil Kerja dan Indicator</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Terdapat {{ $errors->count() }} kesalahan dalam input Anda
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('performance-agreements.update', $performanceAgreement->id) }}"
                id="workResultForm">
                @csrf
                @method('PUT')

                <div
                    class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Detail Utama Perjanjian Kinerja
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <label for="title"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Perjanjian
                            Kinerja</label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $performanceAgreement->title) }}"
                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Existing Work Results -->
                @foreach ($performanceAgreement->workResults as $workResultIndex => $workResult)
                    <div x-data="{ isEditing: false }" class="mb-6">
                        <div
                            class="bg-white  rounded-lg shadow-md overflow-hidden border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div
                                class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 flex justify-between items-center dark:from-gray-700 dark:to-gray-800 dark:border-gray-700">

                                {{-- Teks judul diberi warna terang untuk mode gelap --}}
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    Work Result #{{ $loop->iteration }}
                                </h3>

                                {{-- Tombol (dan ikon di dalamnya) diberi warna terang untuk mode gelap --}}
                                <button type="button" @click="toggleSection({{ $workResultIndex }})"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">

                                    <svg x-show="!isOpen({{ $workResultIndex }})" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <svg x-show="isOpen({{ $workResultIndex }})" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="isOpen({{ $workResultIndex }})" x-collapse class="px-6 py-4 space-y-4">
                                <!-- Work Result Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Deskripsi Work Result
                                    </label>
                                    <textarea name="work_results[{{ $workResult->id }}][description]"
                                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        rows="2" required>{{ $workResult->description }}</textarea>
                                </div>
                                <!-- Penugasan Dari -->
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Penugasan
                                        Dari</label>
                                    <input type="text" name="work_results[{{ $workResult->id }}][penugasan_dari]"
                                        value="{{ $workResult->penugasan_dari }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 ark:border-gray-600">
                                </div>

                                <!-- Existing Indicators -->
                                <div>
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Indicators
                                        </h4>
                                        <button type="button" @click="addNewIndicator({{ $workResult->id }})"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Tambah Indicator
                                        </button>
                                    </div>

                                    @foreach ($workResult->indicators as $indicator)
                                        <div
                                            class="bg-gray-50 p-4 rounded-md mb-3 border border-gray-200 dark:bg-gray-700/50 dark:border-gray-600">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                        Deskripsi Indicator
                                                    </label>
                                                    <textarea name="work_results[{{ $workResult->id }}][indicators][{{ $indicator->id }}][description]"
                                                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                        rows="2" required>{{ $indicator->description }}</textarea>
                                                </div>
                                                <div class="space-y-3">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                            Target
                                                        </label>
                                                        <input type="text"
                                                            name="work_results[{{ $workResult->id }}][indicators][{{ $indicator->id }}][target]"
                                                            value="{{ $indicator->target }}"
                                                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                            Perspektif
                                                        </label>
                                                        <input type="text"
                                                            name="work_results[{{ $workResult->id }}][indicators][{{ $indicator->id }}][perspektif]"
                                                            value="{{ $indicator->perspektif }}"
                                                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Add New Work Result -->
                <div x-data="{ expanded: false }" class="mb-6">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-dashed border-blue-300">
                        <button type="button" @click="expanded = !expanded"
                            class="w-full px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-blue-700">Tambah Work Result Baru</h3>
                            <svg x-show="!expanded" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <svg x-show="expanded" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7" />
                            </svg>
                        </button>

                        <div x-show="expanded" x-collapse class="px-6 py-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Work
                                    Result</label>
                                <textarea name="new_work_result[description]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    rows="3" placeholder="Masukkan deskripsi work result"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Penugasan Dari</label>
                                <input type="text" name="new_work_result[penugasan_dari]"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan penugasan dari">
                            </div>

                            <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
                                <h4 class="text-md font-semibold text-gray-700 mb-3">Indicator Baru</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi
                                            Indicator</label>
                                        <textarea name="new_work_result[new_indicator][description]"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            rows="2" placeholder="Masukkan deskripsi indicator"></textarea>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                                            <input type="text" name="new_work_result[new_indicator][target]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Masukkan target">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 mb-1">Perspektif</label>
                                            <input type="text" name="new_work_result[new_indicator][perspektif]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Masukkan perspektif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('performance-agreements.show', $performanceAgreement) }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('workResultEditor', () => ({
                openSections: [],

                init() {
                    // Buka semua section saat pertama kali load
                    this.$nextTick(() => {
                        document.querySelectorAll('[x-data^="workResult"]').forEach((_,
                            index) => {
                            this.openSections.push(index);
                        });
                    });
                },

                toggleSection(index) {
                    if (this.isOpen(index)) {
                        this.openSections = this.openSections.filter(i => i !== index);
                    } else {
                        this.openSections.push(index);
                    }
                },

                isOpen(index) {
                    return this.openSections.includes(index);
                },

                addNewIndicator(workResultId) {
                    const newIndicator = {
                        description: '',
                        target: '',
                        perspektif: ''
                    };

                    // Dalam implementasi real, ini akan menambah data ke server
                    console.log('Adding new indicator to work result:', workResultId, newIndicator);
                    alert('Fitur menambah indicator akan diimplementasi dengan AJAX');
                },

                submitForm() {
                    console.log('Form submitted');
                    // Diimplementasi dengan form submit biasa
                    document.getElementById('workResultForm').submit();
                }
            }));
        });
    </script>
</x-layouts.app>
