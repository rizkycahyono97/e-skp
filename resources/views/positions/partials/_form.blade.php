<div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

    <div class="sm:col-span-2">
        <label for="position_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Position
            Name</label>
        <input type="text" name="position_name" id="position_name"
            value="{{ old('position_name', $position->position_name ?? '') }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            required>
    </div>

</div>
