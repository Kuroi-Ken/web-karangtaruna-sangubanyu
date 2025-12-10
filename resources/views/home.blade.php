<x-layout :hideHeader="true" :transparent="true" :fullScreen="true">
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Hero Section dengan Background Image Full Screen -->
    <div class="h-screen w-full overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            @php
                $heroImage = \App\Models\Image::where('is_hero', true)->first();
            @endphp
            
            @if($heroImage)
                <img src="{{ Storage::url($heroImage->path) }}"
                     alt="{{ $heroImage->title }}"
                     class="h-full w-full object-cover">
            @else
                <div class="h-full w-full bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900"></div>
            @endif

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Content Section -->
    <div id="content" class="bg-gray-900">
        
        <!-- Gallery Carousel Section -->
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 scroll-reveal">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white sm:text-4xl mb-4">
                    Galeri Kegiatan
                </h2>
                <p class="text-gray-400 text-lg">
                    Dokumentasi kegiatan dan program Karang Taruna
                </p>
            </div>

            @php
                $galleryImages = \App\Models\Image::where('is_active', true)
                    ->where('is_hero', false)
                    ->orderBy('order')
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            @if ($galleryImages->count() > 0)
                <!-- Carousel Container -->
                <div class="relative">
                    <div class="overflow-hidden rounded-2xl">
                        <div id="gallery-carousel" class="flex transition-transform duration-500 ease-out">
                            @foreach ($galleryImages as $image)
                                <div class="min-w-full">
                                    <div class="relative h-[500px] group">
                                        <img src="{{ Storage::url($image->path) }}"
                                             alt="{{ $image->title }}"
                                             class="w-full h-full object-cover">
                                        
                                        <!-- Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                                            <div class="absolute bottom-0 left-0 right-0 p-8">
                                                <h3 class="text-white font-bold text-2xl mb-2">{{ $image->title }}</h3>
                                                @if($image->description)
                                                    <p class="text-gray-300 text-base">{{ $image->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    @if($galleryImages->count() > 1)
                        <button id="prev-btn" 
                                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button id="next-btn" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <!-- Dots Indicator -->
                        <div class="flex justify-center gap-2 mt-6">
                            @foreach ($galleryImages as $index => $image)
                                <button class="carousel-dot w-3 h-3 rounded-full transition {{ $index === 0 ? 'bg-indigo-600 w-8' : 'bg-gray-600' }}" 
                                        data-index="{{ $index }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-400 text-lg">Belum ada gambar dalam galeri.</p>
                </div>
            @endif
        </div>

        <!-- Blog Highlights Section -->
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 scroll-reveal">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white sm:text-4xl mb-4">
                    Kegiatan Terbaru
                </h2>
                <p class="text-gray-400 text-lg">
                    Informasi dan berita terkini dari Karang Taruna
                </p>
            </div>

            @php
                $latestPosts = \App\Models\Post::with(['author', 'category'])
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            @endphp

            @if ($latestPosts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    @foreach ($latestPosts as $post)
                        <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
                            <!-- Post Image -->
                            @if($post->image)
                                <div class="relative h-56 overflow-hidden">
                                    <img src="{{ Storage::url($post->image) }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                </div>
                            @else
                                <div class="relative h-56 bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Post Content -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-indigo-400 bg-indigo-500/10 rounded-full mb-3">
                                    {{ $post->category->activity }}
                                </span>

                                <!-- Title -->
                                <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-indigo-400 transition">
                                    {{ $post->title }}
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-gray-400 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($post->body), 120) }}
                                </p>

                                <!-- Meta Info -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <img class="w-8 h-8 rounded-full" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($post->author_name) }}&background=6366f1&color=fff" 
                                             alt="{{ $post->author_name }}">
                                        <div>
                                            <p class="text-xs text-gray-400">{{ $post->author_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('post.show', $post->id) }}" 
                                       class="text-indigo-400 hover:text-indigo-300 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View All Posts Button -->
                <div class="text-center">
                    <a href="/posts" 
                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-4 rounded-xl transition-all hover:scale-105 shadow-lg">
                        <span>Lihat Semua Kegiatan</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-400 text-lg">Belum ada kegiatan yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Carousel Script -->
    <script src="js/home.js"></script>
</x-layout>