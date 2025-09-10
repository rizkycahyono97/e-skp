<x-layouts.app>
    <div class="flex justify-end mb-4">
        <a href="{{ route('roles.create') }}">
            <button type="button" class="text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg">
                Create New Role
            </button>
        </a>
    </div>

    <x-table :headers="['No', 'Role Name', 'Action']" :rows="$roles->map(function ($role, $index) use ($roles) {
        return [
            'no' => $index + 1 + ($roles->currentPage() - 1) * $roles->perPage(),
            'name' => $role->name,
            'actions' => view('roles.partials.actions', compact('role'))->render(),
        ];
    })" />
</x-layouts.app>
