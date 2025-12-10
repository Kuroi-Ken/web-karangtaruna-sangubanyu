<nav class="bg-gray-800 sticky top-0 z-[100] shadow-lg">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo & Desktop Menu -->
            <div class="flex items-center">
                <a href="/" class="flex-shrink-0">
                    <img class="h-10 w-10" src="{{ asset('assets/kartur.png') }}" alt="Karang Taruna Logo" />
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

            <!-- Desktop Auth Section -->
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6 gap-3">
                    @guest
                    <a href="{{ route('login') }}"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition shadow-lg">
                        Admin
                    </a>
                    @else
                    <div class="flex items-center gap-3 bg-gray-700/50 rounded-lg px-3 py-1.5">
                        <div class="flex items-center gap-2">
                            <div class="size-7 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">
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

            <!-- Mobile menu button - PERBAIKAN DENGAN Z-INDEX SUPER TINGGI -->
            <div class="flex md:hidden relative z-[150]">
                <button type="button" 
                        id="mobile-menu-button"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                        aria-controls="mobile-menu"
                        aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger icon -->
                    <svg class="block h-6 w-6" id="menu-icon-open" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Close icon (hidden by default) -->
                    <svg class="hidden h-6 w-6" id="menu-icon-close" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <div id="mobile-menu"
         class="md:hidden hidden opacity-0 -translate-y-3 transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]">
        <div class="border-t border-gray-700 pb-3 pt-4">
            @guest
            <div class="px-2">
                <a href="{{ route('login') }}"
                    class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-base font-semibold text-white hover:bg-indigo-700 transition">
                    Admin
                </a>
            </div>
            @else
            <div class="flex items-center justify-center px-5 mb-3 gap-3">
                <div class="ml-3">
                    <div class="text-base font-medium justify-center flex text-white">Admin</div>
                    <div class="text-sm font-medium justify-center flex text-gray-400">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full rounded-md bg-gray-700 px-3 py-2 text-center text-base font-medium text-white hover:bg-gray-600 transition">
                        Logout
                    </button>
                </form>
            </div>
            @endguest
        </div>
        <div class="space-y-1 px-2 pb-3 pt-2">
            <x-navlink href="/" :active="request()->is('/')" class="flex justify-center w-full text-center py-1 text-white hover:bg-white/5 rounded-lg">Home</x-navlink>
            <x-navlink href="/posts" :active="request()->is('posts')" class="flex justify-center w-full text-center py-1 text-white hover:bg-white/5 rounded-lg">Blog</x-navlink>
            <x-navlink href="/contact" :active="request()->is('contact')" class="flex justify-center w-full text-center py-1 text-white hover:bg-white/5 rounded-lg">Kontak</x-navlink>
            <x-navlink href="/struktur" :active="request()->is('struktur')" class="flex justify-center w-full text-center py-1 text-white hover:bg-white/5 rounded-lg">Struktur</x-navlink>
            <x-navlink href="/about" :active="request()->is('about')" class="flex justify-center w-full text-center py-1 text-white hover:bg-white/5 rounded-lg">About</x-navlink>
            @auth
            <x-navlink href="/admin/posts" :active="request()->is('admin/*')" class="flex justify-center w-full text-center py-1 text-white rounded-lg hover:bg-white/5">Admin Panel</x-navlink>
            @endauth
        </div>
    </div>
</nav>

{{-- INLINE SCRIPT SEBAGAI FALLBACK --}}
<script src="{{ asset('js/navbar.js') }}">
</script>