<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <title>Dashboard Admin</title>
</head>

<body class="h-full">
    <div x-data="{ openSidebar: false, openMenu: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 w-64 bg-white border-r overflow-y-auto transform transition-transform duration-300 ease-in-out z-50 md:static md:translate-x-0">
            <div class="p-4">
                <a href="#" class="flex justify-center mb-6 font-semibold text-sm">
                    SMK NEGERI 1 LEWOLEBA
                </a>
                <div class="flex flex-col items-center -mx-2">
                    <img class="w-24 h-24 rounded-full object-cover" src="{{ asset('images/logo.png') }}" alt="avatar">
                    <h4 class="mt-2 font-medium text-gray-800">Admin</h4>
                    <p class="text-sm text-gray-600">admin@gmail.com</p>
                </div>
            </div>
            <nav class="px-4 space-y-2">
                <a class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg" href="/data_guru">
                    <span class="ml-2 font-medium">Data Guru</span>
                </a>
                <a class="flex items-center px-4 py-2 text-gray-600 bg-gray-100 rounded-lg" href="#">
                    <span class="ml-2">Data Siswa</span>
                </a>
                <a class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg" href="/data_kelas">
                    <span class="ml-2 font-medium">Data Kelas</span>
                </a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col bg-gray-100">
            <!-- Topbar -->
            <header class="bg-white p-4 shadow-md flex items-center justify-between">
                <!-- Left: Menu toggle -->
                <div class="flex items-center gap-2">
                    <button @click="openSidebar = !openSidebar"
                        class="p-2 text-gray-600 rounded-md hover:bg-gray-100 focus:outline-none md:hidden">
                        <!-- Hamburger -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="font-semibold text-lg md:text-xl">Dashboard</h1>
                </div>

                <!-- Right: Settings dropdown -->
                <div class="relative" x-data="{ openMenu: false }">
                    <button @click="openMenu = !openMenu"
                        class="flex items-center gap-2 p-2 rounded-md hover:bg-gray-100 focus:outline-none">
                        <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 rounded-full" alt="avatar">
                        <span class="hidden sm:inline font-medium text-gray-700">Admin</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="openMenu" @click.away="openMenu = false"
                        class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                        <a href="/profile"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Change Profile</a>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-4 md:p-6 overflow-auto">
                <div class="bg-white p-4 md:p-6 rounded-2xl shadow-md">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                        <h2 class="text-xl md:text-2xl font-semibold">Data Siswa</h2>
                        <a class="inline-block rounded bg-indigo-600 px-5 py-2 text-sm font-medium text-white transition hover:scale-105 hover:shadow-xl"
                            href="/tambah_siswa">
                            Tambah Data
                        </a>
                    </div>

                    <!-- Responsive table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Operasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-2">Budi Santoso</td>
                                    <td class="px-4 py-2">123456</td>
                                    <td class="px-4 py-2">Laki-laki</td>
                                    <td class="px-4 py-2">X TKJ-A</td>
                                    <td class="px-4 py-2">
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded mr-2 hover:bg-blue-600">Update</button>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                                    </td>
                                </tr>
                                <!-- More rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>