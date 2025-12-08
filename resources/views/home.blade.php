<!-- resources/views/home.blade.php -->
<x-layout :hideHeader="true" :transparent="true" :fullScreen="true">
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Hero Section dengan Background Image Full Screen -->
    <div class="h-screen w-full overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/test.jpeg') }}" 
                 alt="Background Hero" 
                 class="h-full w-full object-cover">
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex h-full items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-bold tracking-tight text-white sm:text-6xl md:text-7xl mb-6 animate-fade-in">
                    Selamat Datang di<br>
                    <span class="text-indigo-400">Karang Taruna Desa Sangubanyu</span>
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg sm:text-xl text-gray-200 mb-8">
                    Wadah pengembangan generasi muda yang berakhlak, kreatif, dan peduli terhadap masyarakat
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/posts" 
                       class="rounded-lg bg-indigo-600 px-8 py-3 text-base font-semibold text-white shadow-lg hover:bg-indigo-700 transition-all hover:scale-105">
                        Lihat Kegiatan
                    </a>
                    <a href="/about" 
                       class="rounded-lg bg-white/10 backdrop-blur-sm px-8 py-3 text-base font-semibold text-white border-2 border-white/20 hover:bg-white/20 transition-all hover:scale-105">
                        Tentang Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <a href="#content" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Content Section (Gallery) -->
    <div id="content" class="bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white sm:text-4xl mb-4">
                    Galeri Kegiatan
                </h2>
                <p class="text-gray-400 text-lg">
                    Dokumentasi kegiatan dan program Karang Taruna
                </p>
            </div>

            @if ($images->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($images as $image)
                        <div class="bg-gray-800 rounded-lg overflow-hidden hover:shadow-xl transition-all hover:scale-105 group">
                            <div class="relative overflow-hidden">
                                <img src="{{ Storage::url($image->path) }}" 
                                     alt="{{ $image->title }}"
                                     class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-white font-semibold text-lg mb-2">{{ $image->title }}</h3>
                                @if ($image->description)
                                    <p class="text-gray-400 text-sm">{{ $image->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-400 py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-xl">Belum ada gambar untuk ditampilkan.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out;
        }
    </style>
</x-layout>
```