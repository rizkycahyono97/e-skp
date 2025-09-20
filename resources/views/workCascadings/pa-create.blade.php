<x-layouts.app>

    <x-partials.breadcrumbs :items="$breadcrumbs" />

    {{-- Panel atas --}}
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Hasil Kerja Induk
                        </dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $parentIndicator->workResult->description }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Indikator Induk
                        </dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $parentIndicator->description }}
                        </dd>
                    </div>
                </dl>
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Milik:
                            <span
                                class="font-medium text-gray-700 dark:text-gray-300">{{ $parentIndicator->workResult->performanceAgreement->user->name }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>
    </div>

    {{-- Form Filter --}}
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        <form method="GET" id="cascading-form" action="#" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit</label>
                <select name="unit" id="unit"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @selected($filters['unit'] ?? '' == $unit->id)>{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Posisi</label>
                <select name="position" id="position"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Posisi</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}" @selected($filters['position'] ?? '' == $position->id)>{{ $position->position_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit"
                    class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/80">Filter</button>
                <a href="#"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500">Reset</a>
            </div>
        </form>
    </div>

    {{-- Form Utama & Tabel User --}}
    <form method="POST" action="{{ route('work-cascadings.pa-store') }}">
        @csrf
        <input type="hidden" name="parent_indicator_id" value="{{ $parentIndicator->id }}">
        {{-- <input type="hidden" name="child_pa_id" value="{{ $parentIndicator->workResult->performanceAgreement->id }}"> --}}

        <div
            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-slate-100 uppercase bg-primary dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Check</th>
                        <th scope="col" class="px-6 py-3">Username</th>
                        <th scope="col" class="px-6 py-3">Unit Kerja</th>
                        <th scope="col" class="px-6 py-3">Jabatan</th>
                        {{-- <th scope="col" class="px-6 py-3">Role</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="rounded">
                            </td>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $user->username }}
                            </th>
                            <td class="px-6 py-4">{{ optional($user->unit)->unit_name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ optional($user->position)->position_name ?? '-' }}</td>
                            {{-- <td class="px-6 py-4">{{ $user->getRoleNames()->implode(', ') }}</td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6">Tidak ada user yang cocok dengan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <button type="submit"
                class="px-6 py-3 bg-primary text-white font-semibold rounded-lg shadow-md hover:bg-primary/80">
                Simpan Cascading
            </button>
        </div>
    </form>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</x-layouts.app>
