<x-layouts.app>

    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <div class="max-w-4xl mx-auto mt-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md p-6"
        x-data="{
            workResults: [
                { description: '', indicators: [{ description: '' }] }
            ]
        }">

        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Create Perjanjian Kerja</h2>

        <form method="POST" action="{{ route('performance-agreements.store') }}">
            @csrf

            <div class="mb-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Judul PA</label>
                    <input type="text" name="title"
                        class="w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg shadow-sm focus:ring-primary focus:border-primary" />
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Tahun</label>
                    <input type="number" name="year"
                        class="w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg shadow-sm focus:ring-primary focus:border-primary" />
                </div>
            </div>

            <template x-for="(wr, wrIndex) in workResults" :key="wrIndex">
                <div
                    class="mb-6 border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900/30">

                    <div class="flex items-center justify-between mb-3">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-white">Hasil Kerja <span
                                x-text="wrIndex + 1"></span></label>
                        <button type="button" @click="workResults.splice(wrIndex, 1)"
                            class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 text-sm"
                            x-show="workResults.length > 1">Hapus</button>
                    </div>
                    <input type="text" x-model="wr.description" :name="`work_results[${wrIndex}][description]`"
                        class="w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg shadow-sm focus:ring-primary focus:border-primary mb-4"
                        placeholder="Deskripsi hasil kerja" />

                    <div class="ml-4 border-l-2 border-gray-200 dark:border-gray-600 pl-4">
                        {{-- 1. Label "Indicators" ditambahkan di sini --}}
                        <label
                            class="block text-sm font-medium mb-2 text-gray-600 dark:text-gray-300">Indicators</label>

                        <div class="space-y-3">
                            <template x-for="(ind, indIndex) in wr.indicators" :key="indIndex">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                    <input type="text" x-model="ind.description"
                                        :name="`work_results[${wrIndex}][indicators][${indIndex}][description]`"
                                        class="flex-1 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg shadow-sm focus:ring-primary focus:border-primary"
                                        placeholder="Deskripsi indikator" />
                                    <button type="button" @click="wr.indicators.splice(indIndex, 1)"
                                        class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 text-sm"
                                        x-show="wr.indicators.length > 1">Hapus</button>
                                </div>
                            </template>

                            <button type="button" @click="wr.indicators.push({ description: '' })"
                                class="mt-2 text-xs text-primary dark:text-blue-400 hover:underline">
                                + Tambah Indikator
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <button type="button" @click="workResults.push({ description: '', indicators: [{ description: '' }] })"
                class="w-full border border-dashed border-primary dark:border-blue-400 text-primary dark:text-blue-400 py-2 rounded-lg hover:bg-primary/5 dark:hover:bg-blue-400/10">
                + Tambah Hasil Kerja
            </button>

            <div class="mt-6">
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/80 shadow">
                    Create PK
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
