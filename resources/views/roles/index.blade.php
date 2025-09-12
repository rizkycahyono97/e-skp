<x-layouts.app>
    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <x-partials.header :title="$header['title']" :description="$header['description']">
        <x-slot name="actions">
            <a href="{{ route('roles.create') }}">
                <button type="button" class="text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg">
                    Buat role
                </button>
            </a>
        </x-slot>
    </x-partials.header>

    <x-table :headers="['No', 'Role Name', 'Action']" :rows="$roles->map(function ($role, $index) use ($roles) {
        return [
            'no' => $index + 1 + ($roles->currentPage() - 1) * $roles->perPage(),
            'name' => $role->name,
            'actions' => view('roles.partials.actions', compact('role'))->render(),
        ];
    })" />
</x-layouts.app>
