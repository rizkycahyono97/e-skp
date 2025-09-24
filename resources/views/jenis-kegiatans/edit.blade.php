<x-layouts.app>
    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <div
        class="p-8 mx-auto max-w-2xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">

        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update Jenis Kegiatan</h2>

        <form action="{{ route('jenis-kegiatans.update', $jenisKegiatan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis
                        Kegiatan</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        value="{{ old('name', $jenisKegiatan->nama) }}" placeholder="Type product name" required="">
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button type="submit"
                    class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">Update</button>

                <a href="{{ route('jenis-kegiatans.index') }}">
                    <button type="button"
                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2">Back</button>
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
