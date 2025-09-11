<x-layouts.app>
    <div class="flex justify-end mb-4">
        <a href="{{ route('users.create') }}">
            <button type="button" class="text-white bg-green-600 hover:bg-green-700 px-5 py-2.5 rounded-lg">
                Create New User
            </button>
        </a>
    </div>
    <x-table :headers="['No', 'Name', 'Username', 'Nip', 'Email', 'Position', 'Unit', 'Role', 'Action']" :rows="$users->map(function ($user, $index) use ($users) {
        return [
            'no' => $index + 1 + ($users->currentPage() - 1) * $users->perPage(),
            'name' => $user->name,
            'username' => $user->username,
            'nip' => $user->nip,
            'email' => $user->email,
            'position' => $user->position->position_name,
            'unit' => $user->unit->unit_name,
            'role' => $user->getRoleNames()->implode(', '),
            'actions' => view('users.partials.actions', compact('user'))->render(),
        ];
    })">

    </x-table>
</x-layouts.app>
