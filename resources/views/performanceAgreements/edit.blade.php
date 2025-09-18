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
                id="workResultForm" x-data="workResultEditor()">
                @csrf
                @method('PUT')

                <div
                    class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Detail Utama Perjanjian Kinerja
                        </h3>
                    </div>

                    {{-- check jika cascaded_from ada  --}}
                    @if ($performanceAgreement->cascaded_from)
                        <div class="px-6 py-4">
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Judul Perjanjian Kinerja <span
                                    class="text-sm font-normal text-blue-600 dark:text-blue-400">(Diturunkan)</span>
                            </label>

                            <div
                                class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md shadow-sm">
                                {{ $performanceAgreement->title }}
                            </div>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Judul ini tidak dapat diubah karena diturunkan dari perjanjian kinerja atasan.
                            </p>
                        </div>
                    @else
                        <div class="px-6 py-4">
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Perjanjian
                                Kinerja</label>
                            <input type="text" id="title" name="title"
                                value="{{ old('title', $performanceAgreement->title) }}"
                                class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    @endif
                </div>

                <!-- workresult yang sudah ada -->
                @foreach ($performanceAgreement->workResults as $workResultIndex => $workResult)
                    <div class="mb-6">
                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <div @click="toggleSection({{ $workResultIndex }})"
                                class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 flex justify-between items-center dark:from-gray-700 dark:to-gray-800 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    Hasil Kerja {{ $loop->iteration }}
                                </h3>
                                <button type="button"
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
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Deskripsi Work Result
                                    </label>
                                    <textarea name="work_results[{{ $workResult->id }}][description]"
                                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        rows="2" required>{{ $workResult->description }}</textarea>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-300">Penugasan
                                        Dari</label>
                                    <input type="text" name="work_results[{{ $workResult->id }}][penugasan_dari]"
                                        value="{{ $workResult->penugasan_dari }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                </div>

                                <!-- Indicators Section -->
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

                                    {{-- Loop untuk Indikator yang SUDAH ADA --}}
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
                                                    {{-- <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                            Target
                                                        </label>
                                                        <input type="text"
                                                            name="work_results[{{ $workResult->id }}][indicators][{{ $indicator->id }}][target]"
                                                            value="{{ $indicator->target }}"
                                                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                    </div> --}}
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

                                    {{-- indicator baru --}}
                                    <div class="mt-4 space-y-3">
                                        <template
                                            x-for="(newIndicator, index) in newIndicators[{{ $workResult->id }}] || []"
                                            :key="index">
                                            <div
                                                class="bg-green-50 dark:bg-green-900/30 p-4 rounded-md border border-dashed border-green-400 dark:border-green-600 relative animate-fade-in">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi
                                                            Indicator Baru</label>
                                                        <textarea :name="`new_indicators[{{ $workResult->id }}][${index}][description]`" x-model="newIndicator.description"
                                                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-md shadow-sm"
                                                            rows="2" placeholder="Deskripsi Indikator Baru" required></textarea>
                                                    </div>
                                                    <div class="space-y-3">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target</label>
                                                            <input type="text"
                                                                :name="`new_indicators[{{ $workResult->id }}][${index}][target]`"
                                                                x-model="newIndicator.target"
                                                                class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-md shadow-sm"
                                                                placeholder="Target Indikator Baru">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Perspektif</label>
                                                            <input type="text"
                                                                :name="`new_indicators[{{ $workResult->id }}][${index}][perspektif]`"
                                                                x-model="newIndicator.perspektif"
                                                                class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-white rounded-md shadow-sm"
                                                                placeholder="Perspektif Indikator Baru">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Tombol hapus indikator baru --}}
                                                <button type="button"
                                                    @click="removeNewIndicator({{ $workResult->id }}, index)"
                                                    class="absolute top-2 right-2 text-red-500 hover:text-red-700 dark:hover:text-red-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- jika ada work result baru --}}
                <fieldset class="mt-6">
                    <legend class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Tambah Work Result Baru
                    </legend>

                    <div class="space-y-6">
                        <template x-for="(newWr, workResultIndex) in newWorkResults" :key="workResultIndex">

                            <div
                                class="bg-white rounded-lg shadow-md overflow-hidden border border-dashed border-blue-300 dark:bg-gray-800 dark:border-blue-500 animate-fade-in">

                                <div @click="newWr.isOpen = !newWr.isOpen"
                                    class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 flex justify-between items-center dark:from-gray-700 dark:to-gray-800 dark:border-gray-600 cursor-pointer">
                                    <h3 class="font-semibold text-gray-800 dark:text-white">
                                        Work Result Baru #<span x-text="workResultIndex + 1"></span>
                                    </h3>
                                    <div class="flex items-center space-x-3">
                                        <button type="button" @click.stop="removeNewWorkResult(workResultIndex)"
                                            class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 text-sm font-medium">
                                            Hapus
                                        </button>
                                        <button type="button"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                            <svg x-show="!newWr.isOpen" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                            <svg x-show="newWr.isOpen" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div x-show="newWr.isOpen" x-collapse class="px-6 py-4 space-y-4">
                                    <div>
                                        <label :for="`new_wr_desc_${workResultIndex}`"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi
                                            Work Result</label>
                                        <textarea :name="`new_work_results[${workResultIndex}][description]`" :id="`new_wr_desc_${workResultIndex}`"
                                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm"
                                            rows="2" placeholder="Masukkan deskripsi work result" required></textarea>
                                    </div>

                                    <div>
                                        <label :for="`new_wr_penugasan_${workResultIndex}`"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Penugasan
                                            Dari</label>
                                        <input type="text"
                                            :name="`new_work_results[${workResultIndex}][penugasan_dari]`"
                                            :id="`new_wr_penugasan_${workResultIndex}`"
                                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm"
                                            placeholder="Masukkan penugasan dari">
                                    </div>

                                    <div>
                                        <div class="flex justify-between items-center mb-3">
                                            <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">
                                                Indicators</h4>
                                            <button type="button"
                                                @click="addNewIndicatorToNewWorkResult(workResultIndex)"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                                <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Tambah Indicator
                                            </button>
                                        </div>

                                        <div class="space-y-3">
                                            <template x-for="(indicator, indicatorIndex) in newWr.new_indicators"
                                                :key="indicatorIndex">
                                                <div
                                                    class="bg-gray-50 p-4 rounded-md border border-gray-200 dark:bg-gray-700/50 dark:border-gray-600 relative">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                Deskripsi Indicator
                                                            </label>
                                                            <textarea :name="`new_work_results[${workResultIndex}][new_indicators][${indicatorIndex}][description]`"
                                                                class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 rounded-md shadow-sm"
                                                                rows="2" placeholder="Deskripsi Indikator Baru" required></textarea>
                                                        </div>
                                                        <div class="space-y-3">
                                                            <div>
                                                                <label
                                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                    Perspektif
                                                                </label>
                                                                <input type="text"
                                                                    :name="`new_work_results[${workResultIndex}][new_indicators][${indicatorIndex}][perspektif]`"
                                                                    class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 rounded-md shadow-sm"
                                                                    placeholder="Perspektif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        @click.stop="removeNewIndicatorFromNewWorkResult(workResultIndex, indicatorIndex)"
                                                        class="absolute top-2 right-2 text-red-500 hover:text-red-700 dark:hover:text-red-400">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-6">
                        <button type="button" @click="addNewWorkResult()"
                            class="w-full flex items-center justify-center border-2 border-dashed border-blue-400 text-blue-500 dark:border-blue-500 dark:text-blue-400 py-2.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Hasil Kerja Baru
                        </button>
                    </div>
                </fieldset>

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
                newWorkResults: [],
                newIndicators: {},

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

                addNewWorkResult() {
                    this.newWorkResults.push({
                        description: '',
                        penugasan_dari: '',
                        new_indicators: [{
                            description: '',
                            target: '',
                            perspektif: ''
                        }],
                    });
                },

                removeNewWorkResult(index) {
                    this.newWorkResults.splice(index, 1);
                },

                addNewIndicator(workResultId) {
                    if (!this.newIndicators[workResultId]) {
                        this.newIndicators[workResultId] = [];
                    }

                    this.newIndicators[workResultId].push({
                        description: '',
                        target: '',
                        perspektif: ''
                    });
                },

                removeNewIndicator(workResultId, index) {
                    if (this.newIndicators[workResultId] && this.newIndicators[workResultId][index]) {
                        this.newIndicators[workResultId].splice(index, 1);
                    }
                },

                addNewIndicatorToNewWorkResult(workResultIndex) {
                    this.newWorkResults[workResultIndex].new_indicators.push({
                        description: '',
                        target: '',
                        perspektif: ''
                    });
                },

                removeNewIndicatorFromNewWorkResult(workResultIndex, indicatorIndex) {
                    this.newWorkResults[workResultIndex].new_indicators.splice(indicatorIndex, 1);
                },

                submitForm() {
                    document.getElementById('workResultForm').submit();
                }
            }));
        });
    </script>
</x-layouts.app>
