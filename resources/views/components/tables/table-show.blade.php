{{-- resources/views/components/detail-view.blade.php --}}
<div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">


    <div class="border-t border-gray-200 dark:border-gray-700">
        <dl>
            @foreach ($fields as $field)
                <div
                    class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 {{ $loop->odd ? 'bg-gray-50 dark:bg-gray-900' : 'bg-white dark:bg-gray-800' }}">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ $field['label'] }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                        {{ $field['value'] }}
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>

    <div class="px-4 py-4 sm:px-6 bg-gray-50 dark:bg-gray-900/50 flex justify-end space-x-3">
        {{ $actions }}
    </div>
</div>
