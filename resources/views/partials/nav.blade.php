<nav class="bg-blue-900" x-data="{ isOpen: false }">
    @php
        $user = auth()->user();

        if ($user->role === 'teacher' && $user->teacher) {
            $foto = $user->teacher->foto;
        } elseif ($user->role === 'student' && $user->student) {
            $foto = $user->student->foto;
        } else {
            $foto = null; // for admin or no photo
        }
    @endphp

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center gap-5">
                    <img class="size-9" src="{{ asset('images/logo.png') }}" alt="logo" />
                    <span class="text-white justify-center font-semibold md:text-lg lg:text-xl">SMKN 1 Lewoleba</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        <div class="flex items-center gap-3">
                            <span class="text-white text-md md:text-lg ">{{ auth()->user()->name }}</span>
                            <button type="button" @click="isOpen = !isOpen" class="cursor-pointer relative flex max-w-xs items-center rounded-full bg-blue-900 text-sm focus:outline-hidden focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-black" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <img class="size-8 rounded-full bg-white"
                                    src="{{ $foto ? asset('storage/'.$foto) : asset('images/profile.png') }}" alt="profile" />
                            </button>
                        </div>
                        <div
                            x-show="isOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75 transform"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="cursor-pointer absolute right-0 z-10 mt-2 w-35 origin-top-right rounded-md bg-white hover:bg-black py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
                            <!-- <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a> -->
                            <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="cursor-pointer block px-4 py-2 w-full text-sm text-gray-700  hover:text-white">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button @click="isOpen = !isOpen" type="button" class="relative inline-flex items-center justify-center rounded-md bg-blue-900 p-2 text-gray-300 hover:bg-black hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-black/5 focus:outline-hidden" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" x-cloak class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
        </div>
        <div class="flex items-center justify-between border-t border-black pt-4 pb-3">
            <div class="flex items-center px-5">
                <div class="shrink-0">
                    <img class="size-10 sm:size-8 rounded-full bg-white"
                        src="{{ $foto ? asset('storage/'.$foto) : asset('images/profile.png') }}" alt="profile" />
                </div>
                <div class="ml-3">
                    <div class="text-base/5 font-medium text-white">{{ auth()->user()->name }}</div>
                    <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <!-- <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-black hover:text-white">Profile</a> -->
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="cursor-pointer block rounded-md px-3 py-2 mt-2 w-25 text-base font-medium text-gray-400 hover:bg-black hover:text-white">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>