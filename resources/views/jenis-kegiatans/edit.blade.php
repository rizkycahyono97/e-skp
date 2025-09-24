<x-layouts.app>
    <x-partials.breadcrumbs :items="$breadcrumbs" />

    <div
        class="p-8 mx-auto max-w-2xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">

        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update Jenis Kegiatan</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg" role="alert">
                <div class="font-bold">Oops! Ada beberapa masalah:</div>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jenis-kegiatans.update', $jenisKegiatan->id) }}" method="POST">
            @csrf
            @method('PUT')



            @include('jenis-kegiatans.partials._form')

            <div class="flex items-center mt-4 space-x-4">
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
