<nav class="bg-gray-800 sticky top-0 z-50 shadow-lg">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a href="/" class="shrink-0">
                    <img class="w-10 h-10" src="../assets/kartur.png"
                        alt="Your Company" class="size-8" />
                </a>
                <div class="hidden md:block">
                    <div class="ml-7 flex items-baseline space-x-4">
                        <x-navlink href="/" :active="request()->is('/')">Home</x-navlink>
                        <x-navlink href="/posts" :active="request()->is('posts')">Blog</x-navlink>
                        <x-navlink href="/contact" :active="request()->is('contact')">Kontak</x-navlink>
                        <x-navlink href="/struktur" :active="request()->is('struktur')">Struktur</x-navlink>
                        <x-navlink href="/about" :active="request()->is('about')">About</x-navlink>
                        @auth
                        <x-navlink href="/admin/posts" :active="request()->is('admin/*')">Admin Panel</x-navlink>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6 gap-3">
                    @guest
                    <a href="{{ route('login') }}"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-lg ">
                        Admin
                    </a>
                    @else
                    <div class="flex items-center gap-3 bg-gray-700/50 rounded-lg px-3 py-1.5">
                        <div class="flex items-center gap-2">
                            <div
                                class="size-7 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                A
                            </div>
                            <span class="text-white text-sm font-medium">Admin</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="rounded-md bg-gray-700 px-4 py-2 text-sm font-medium text-white hover:bg-gray-600 transition">
                            Logout
                        </button>
                    </form>
                    @endguest
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" command="--toggle" commandfor="mobile-menu"
                    class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="size-6 [[aria-expanded='true']_&]:hidden">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="size-6 [&:not([aria-expanded='true']_*)]:hidden">
                        <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <el-disclosure id="mobile-menu" hidden class="md:hidden [&:not([hidden])]:block">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <x-navlink href="/" :active="request()->is('/')">Home</x-navlink>
            <x-navlink href="/posts" :active="request()->is('posts')">Blog</x-navlink>
            <x-navlink href="/about" :active="request()->is('about')">About</x-navlink>
            <x-navlink href="/contact" :active="request()->is('contact')">Kontak</x-navlink>
            <x-navlink href="/struktur" :active="request()->is('struktur')">Struktur</x-navlink>
            
            @auth
            <x-navlink href="/admin/posts" :active="request()->is('admin/*')">Admin Panel</x-navlink>
            @endauth
        </div>
        <div class="border-t border-white/10 pb-3 pt-4">
            @guest
            <div class="px-2">
                <a href="{{ route('login') }}"
                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-base font-semibold text-white ">
                    Admin
                </a>
            </div>
            @else
            <div class="flex items-center px-5 mb-3">
                <div class="shrink-0">
                    <div
                        class="size-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                        A
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base/5 font-medium text-white">Admin</div>
                    <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full rounded-md bg-gray-700 px-3 py-2 text-center text-base font-medium text-white hover:bg-gray-600">
                        Logout
                    </button>
                </form>
            </div>
            @endguest
        </div>
    </el-disclosure>
</nav>