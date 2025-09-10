<x-layouts.app>
    {{-- 1. Tombol Create ditambahkan di sini --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('roles.create') }}">
            <button type="button"
                class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Create New Role
            </button>
        </a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg rounded-lg">

        {{-- session --}}
        @if (session('success'))
            <div id="alert-3"
                class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                {{-- Ikon checklist --}}
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('success') }}
                </div>

                {{-- Tombol Close --}}
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    onclick="document.getElementById('alert-3').style.display='none'" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border border-primary">
            <thead class="text-xs text-slate-100 uppercase bg-primary dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    {{-- 1. Kolom "No" dibuat jadi yang terkecil --}}
                    <th scope="col"
                        class="px-6 py-3 border-r border-gray-200 dark:border-gray-700 w-1 whitespace-nowrap">
                        No
                    </th>

                    {{-- 2. Kolom "Role Name" dibuat mengisi semua sisa ruang --}}
                    <th scope="col" class="px-6 py-3 border-r border-gray-200 dark:border-gray-700 w-full">
                        Role Name
                    </th>

                    {{-- 3. Kolom "Action" dibuat jadi yang terkecil --}}
                    <th scope="col" class="px-6 py-3 w-1 whitespace-nowrap">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 last:border-b-0">
                        <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-700">
                            {{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-r border-gray-200 dark:border-gray-700">
                            {{ $role->name }}
                        </td>
                        {{-- action --}}
                        <td class="px-4 py-4">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('roles.edit', $role->id) }}">
                                    <button type="button"
                                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-xs px-3 py-1.5 text-center">Edit</button>
                                </a>

                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus role ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-xs px-3 py-1.5 text-center">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            No roles found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
