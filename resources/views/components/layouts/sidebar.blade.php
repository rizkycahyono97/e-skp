<aside class="w-64 bg-secondary dark:bg-gray-800 shadow-md hidden md:block">
    <div class="h-full flex flex-col p-4">
        <h2 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 mb-6">E-SKP</h2>

        <nav class="flex-1 space-y-2">
            <div class="h-full px-3 py-4 overflow-y-auto bg-secondary dark:bg-gray-800">
                <ul class="space-y-2 font-medium">

                    {{-- dashboard --}}
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-2 text-slate-100 rounded-lg dark:text-white hover:bg-slate-800 dark:hover:bg-gray-700 group">
                            <svg class="w-5 h-5 text-slate-200 transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 22 21">
                                <path
                                    d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                <path
                                    d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>

                    {{-- PK --}}
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-slate-100 transition duration-75 rounded-lg group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="pk-dropdown" data-collapse-toggle="pk-dropdown">
                            <svg class="w-5 h-5 text-slate-200 transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Perjanjian Kerja</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="pk-dropdown" class="hidden py-2 space-y-2">
                            @role('Super Admin|Rektor|Dekan|Kaprodi')
                                <li>
                                    <a href="{{ route('performance-agreements.index') }}"
                                        class="flex items-center w-full p-2 text-slate-100 transition duration-75 rounded-lg pl-11 group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700">Perjanjian
                                        Kerja</a>
                                </li>
                                <li>
                                    <a href="{{ route('performance-agreements.persetujuan.index') }}"
                                        class="flex items-center w-full p-2 text-slate-100 transition duration-75 rounded-lg pl-11 group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700">Persetujuan</a>
                                </li>
                            @endrole

                        </ul>
                    </li>

                    {{-- SKP --}}
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-slate-100 transition duration-75 rounded-lg group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="skp-dropdown" data-collapse-toggle="skp-dropdown">
                            <svg class="w-5 h-5 text-slate-200 transition duration-75 dark:text-gray-400 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-3 8a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Zm2 5a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-2-1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H9Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Skp</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="skp-dropdown" class="hidden py-2 space-y-2">
                            @role('Super Admin|Rektor|Dekan|Kaprodi|Dosen|Tendik')
                                <li>
                                    <a href="{{ route('skp-plans.index') }}"
                                        class="flex items-center w-full p-2 text-slate-100 transition duration-75 rounded-lg pl-11 group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700">SKP</a>
                                </li>
                            @endrole

                        </ul>
                    </li>

                    {{-- Master --}}
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-slate-100 transition duration-75 rounded-lg group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="master-dropdown" data-collapse-toggle="master-dropdown">
                            <svg class="shrink-0 w-5 h-5 text-slate-200 transition duration-75 group-hover:text-slate-200 dark:text-gray-400 dark:group-hover:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 7.205c4.418 0 8-1.165 8-2.602C20 3.165 16.418 2 12 2S4 3.165 4 4.603c0 1.437 3.582 2.602 8 2.602ZM12 22c4.963 0 8-1.686 8-2.603v-4.404c-.052.032-.112.06-.165.09a7.75 7.75 0 0 1-.745.387c-.193.088-.394.173-.6.253-.063.024-.124.05-.189.073a18.934 18.934 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.073a10.143 10.143 0 0 1-.852-.373 7.75 7.75 0 0 1-.493-.267c-.053-.03-.113-.058-.165-.09v4.404C4 20.315 7.037 22 12 22Zm7.09-13.928a9.91 9.91 0 0 1-.6.253c-.063.025-.124.05-.189.074a18.935 18.935 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.074a10.163 10.163 0 0 1-.852-.372 7.816 7.816 0 0 1-.493-.268c-.055-.03-.115-.058-.167-.09V12c0 .917 3.037 2.603 8 2.603s8-1.686 8-2.603V7.596c-.052.031-.112.059-.165.09a7.816 7.816 0 0 1-.745.386Z" />
                            </svg>

                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Master</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="master-dropdown" class="hidden py-2 space-y-2">
                            @role('Super Admin')
                                <li>
                                    <a href="{{ route('users.index') }}"
                                        class="flex items-center w-full p-2 text-slate-100 transition duration-75 rounded-lg pl-11 group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700">User</a>
                                </li>
                            @endrole

                            @role('Super Admin')
                                <li>
                                    <a href="{{ route('roles.index') }}"
                                        class="flex items-center w-full p-2 text-slate-100 transition duration-75 rounded-lg pl-11 group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700">Role</a>
                                </li>
                            @endrole

                            @role('Super Admin')
                                <li>
                                    <a href="{{ route('positions.index') }}"
                                        class="flex items-center w-full p-2 text-slate-100 transition duration-75 rounded-lg pl-11 group hover:bg-slate-800 dark:text-white dark:hover:bg-gray-700">Position</a>
                                </li>
                            @endrole
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</aside>
