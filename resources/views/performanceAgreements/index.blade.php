<x-layouts.app>

    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <x-partials.header :title="$header['title']" :description="$header['description']">
        <x-slot name="actions">

            @role('Rektor')
                <a href="{{ route('performance-agreements.create') }}">
                    <button type="button" class="text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg">
                        Buat PK
                    </button>
                </a>
            @endrole
        </x-slot>
    </x-partials.header>

    <x-tables.table :headers="['No', 'Title', 'Cascaded From', 'Year', 'Status', 'Action']" :rows="$pas->map(function ($pa, $index) use ($pas) {
        return [
            'no' => $index + 1 + ($pas->currentPage() - 1) * $pas->perPage(),
            'title' => $pa->title,
            'cascaded from' => $pa->cascaded_from ?? 'null',
            'year' => $pa->year,
            'status' => $pa->status,
            'actions' => view('performanceAgreements.partials.actions', compact('pa')),
        ];
    })">

    </x-tables.table>

</x-layouts.app>
