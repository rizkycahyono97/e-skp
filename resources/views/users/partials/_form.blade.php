<div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

    <div class="sm:col-span-2">
        <label for="nip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
        <input type="text" name="nip" id="nip" value="{{ old('nip', $user->nip ?? '') }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required>
    </div>

    <div class="sm:col-span-2">
        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
        <input type="text" name="username" id="username" value="{{ old('username', $user->username ?? '') }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required>
    </div>

    {{-- Name Input --}}
    <div class="sm:col-span-2">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required>
    </div>

    {{-- Email Input --}}
    <div class="sm:col-span-2">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required>
    </div>

    {{-- Unit Dropdown --}}
    <div class="sm:col-span-2">
        <label for="unit_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit</label>
        <select id="unit_id" name="unit_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option selected disabled>Choose a unit</option>
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}" @selected(old('unit_id', $user->unit_id ?? '') == $unit->id)>
                    {{ $unit->unit_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="position_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position</label>
        <select id="position_id" name="position_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option selected disabled>Choose a position</option>
            @foreach ($positions as $position)
                <option value="{{ $position->id }}" @selected(old('position_id', $user->position_id ?? '') == $position->id)>
                    {{ $position->position_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Password Input --}}
    <div class="sm:col-span-2">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
        <input type="password" name="password" id="password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            {{-- Password tidak wajib di form edit --}} {{ isset($user) ? '' : 'required' }}>
        @if (isset($user))
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Leave blank to keep current password.</p>
        @endif
    </div>
</div>
