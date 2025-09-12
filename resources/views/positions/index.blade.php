<x-layouts.app>
    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <x-partials.header :title="$header['title']" :description="$header['description']">
        <x-slot name="actions">
            <a href="{{ route('positions.create') }}">
                <button type="button" class="text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg">
                    Buat posisi
                </button>
            </a>
        </x-slot>
    </x-partials.header>

    {{-- 3. Komponen Tabel Anda --}}
    <x-table :headers="['No', 'Position Name', 'Action']" :rows="$positions->map(function ($position, $index) use ($positions) {
        return [
            'no' => $index + 1 + ($positions->currentPage() - 1) * $positions->perPage(),
            'position_name' => $position->position_name,
            'actions' => view('positions.partials.actions', compact('position'))->render(),
        ];
    })">
    </x-table>
</x-layouts.app>
