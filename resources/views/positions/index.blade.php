<x-layouts.app>
    <div class="flex justify-end mb-4">
        <a href="{{ route('positions.create') }}">
            <button type="button" class="text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg">
                Create New Position
            </button>
        </a>
    </div>
    <x-table :headers="['No', 'Position Name', 'Action']" :rows="$positions->map(function ($position, $index) use ($positions) {
        return [
            'no' => $index + 1 + ($positions->currentPage() - 1) * $positions->perPage(),
            'position_name' => $position->position_name,
            'actions' => view('positions.partials.actions', compact('position'))->render(),
        ];
    })">

    </x-table>
</x-layouts.app>
