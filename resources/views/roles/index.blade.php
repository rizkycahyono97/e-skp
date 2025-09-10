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

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-slate-100 uppercase bg-primary dark:bg-gray-700 dark:text-gray-400 ">
                <tr>
                    {{-- 2. Garis kolom ditambahkan dengan border-r --}}
                    <th scope="col" class="px-6 py-3 border-r border-gray-200 dark:border-gray-700">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 border-r border-gray-200 dark:border-gray-700">
                        Role Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4 border-r border-gray-200 dark:border-gray-700">
                            {{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-r border-gray-200 dark:border-gray-700">
                            {{ $role->name }}
                        </td>
                        {{-- action --}}
                        <td class="px-4 py-4"> {{-- px-0 diubah ke px-4 agar ada jarak --}}
                            <div class="flex items-center space-x-2"> {{-- space-x-4 dikurangi --}}
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
