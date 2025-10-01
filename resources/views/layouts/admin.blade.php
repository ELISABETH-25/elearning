<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title> {{ $title }} </title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    @include('partials.adminNavbar')

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-md transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-20">
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-lg font-semibold">Menu</h2>
            <!-- Close button for mobile -->
            <button id="closeSidebar" class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <ul class="p-4 space-y-2">
            <div class="flex items-center justify-center mb-5 gap-2">
                <img class="size-15" src="{{ asset('images/logo.png') }}" alt="logo" />
                <span class="justify-center font-semibold md:text-lg lg:text-lg">SMKN 1 Lewoleba</span>
            </div>
            <li><a href="{{ route('admin.index') }}" class="block py-2 px-3 rounded {{ request()->routeIs('admin.index') ? 'bg-violet-100 font-semibold' : 'hover:bg-violet-100' }}">Dashboard</a></li>
            <span class="flex items-center">
                <span class="h-px flex-1 bg-gray-300 dark:bg-gray-600"></span>
            </span>
            <li><a href="{{ route('prodi.show') }}" class="block py-2 px-3 rounded {{ request()->routeIs('prodi.show') ? 'bg-violet-100 font-semibold' : 'hover:bg-violet-100' }}">Program Studi</a></li>
            <li><a href="{{ route('teachers.show') }}" class="block py-2 px-3 rounded {{ request()->routeIs('teachers.show') ? 'bg-violet-100 font-semibold' : 'hover:bg-violet-100' }}">Data Guru</a></li>
            <li><a href="{{ route('students.show') }}" class="block py-2 px-3 rounded {{ request()->routeIs('students.show') ? 'bg-violet-100 font-semibold' : 'hover:bg-violet-100' }}">Data Siswa</a></li>
            <li><a href="{{ route('kelas.show') }}" class="block py-2 px-3 rounded {{ request()->routeIs('kelas.show') ? 'bg-violet-100 font-semibold' : 'hover:bg-violet-100' }}">Data Kelas</a></li>
            <li><a href="{{ route('subjects.show') }}" class="block py-2 px-3 rounded {{ request()->routeIs('subjects.show') ? 'bg-violet-100 font-semibold' : 'hover:bg-violet-100' }}">Mata Pelajaran</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="pt-16 md:pl-64">
        <div class="p-4">
            @yield('content')

            @include('sweetalert::alert')

        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebar = document.getElementById('closeSidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        // Dropdown toggle
        const dropdownToggle = document.getElementById('dropdownToggle');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownToggle.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', (e) => {
            if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>