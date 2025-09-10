<nav class="bg-white dark:bg-gray-800 shadow px-4 py-3 flex items-center justify-between">
    <div class="flex items-center space-x-2">
        <!-- Toggle Sidebar Mobile -->
        <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
            class="md:hidden p-2 text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
            ☰
        </button>

        <h1 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
            {{ $title ?? 'Dashboard' }}
        </h1>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Dark Mode Toggle -->
        <button id="theme-toggle" type="button"
            class="p-2 text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
            🌙
        </button>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button class="flex items-center space-x-2 focus:outline-none">
                <img src="https://ui-avatars.com/api/?name=User" class="w-8 h-8 rounded-full" alt="User">
                <span class="hidden md:block">User</span>
            </button>
        </div>
    </div>
</nav>
