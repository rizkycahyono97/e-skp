<x-layouts.app>

    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <x-partials.header :title="$header['title']" :description="$header['description']" />

    <x-tables.table :headers="['No', 'Title', 'Cascaded From', 'Year', 'Status', 'Action']" :rows="$skps->map(function ($skp, $index) use ($skps) {
        return [
            'no' => $index + 1 + ($skps->currentPage() - 1) * $skps->perPage(),
            'title' => $skp->title,
            'cascaded from' => $skp->cascaded_from ?? 'null',
            'year' => $skp->year,
            'status' => $skp->status,
            'actions' => view('skp-plans.partials.actions', compact('skp')),
        ];
    })">

    </x-tables.table>

</x-layouts.app>
