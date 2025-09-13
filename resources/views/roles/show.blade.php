<x-layouts.app>
    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <x-tables.table-show :fields="$fields">
        <x-slot name="actions">
            <a href="{{ route('roles.index') }}">
                <button type="button"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Back</button>
            </a>

            <a href="{{ route('roles.edit', $role) }}">
                <button type="submit"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Edit</button>

            </a>
        </x-slot>
    </x-tables.table-show>
</x-layouts.app>
