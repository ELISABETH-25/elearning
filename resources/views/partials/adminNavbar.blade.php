<nav class="bg-white shadow-md fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left section: Sidebar toggle button (for mobile) -->
                <div class="flex items-center">
                    <button id="sidebarToggle" class="text-gray-600 hover:text-gray-900 focus:outline-none md:hidden">
                        <!-- Icon: hamburger -->
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Right section: Dropdown -->
                <div class="flex items-center relative">
                    <button id="dropdownToggle" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                        <span class="mr-2">{{ auth()->user()->name }}</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg">
                        <!-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Change Profile
                        </a> -->
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>