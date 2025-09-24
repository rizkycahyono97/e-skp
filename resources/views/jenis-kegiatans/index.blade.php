<x-layouts.app>
    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <x-partials.header :title="$header['title']" :description="$header['description']">
        <x-slot name="actions">
            <a href="{{ route('jenis-kegiatans.create') }}">
                <button type="button" class="text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg">
                    Buat Jenis Kegiatan
                </button>
            </a>
        </x-slot>
    </x-partials.header>

    <x-tables.table :headers="['No', 'Jenis Kegiatan', 'Action']" :rows="$jenisKegiatans->map(function ($jenisKegiatan, $index) use ($jenisKegiatans) {
        return [
            'no' => $index + 1 + ($jenisKegiatans->currentPage() - 1) * $jenisKegiatans->perPage(),
            'name' => $jenisKegiatan->nama,
            'actions' => view('jenis-kegiatans.partials.actions', compact('jenisKegiatan'))->render(),
        ];
    })" />
</x-layouts.app>
