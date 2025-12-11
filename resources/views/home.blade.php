<x-layout :hideHeader="true" :transparent="true" :fullScreen="true">
    <x-slot:title>{{ $title }}</x-slot:title>

    <style>
        .gallery-section,
        .blog-section,
        .leadership-section {
            opacity: 0;
            transform: translateY(100px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .gallery-section.show,
        .blog-section.show,
        .leadership-section.show {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-title,
        .hero-subtitle,
        .hero-buttons {
            opacity: 0;
            transform: translateY(100px);
        }

        .hero-title {
            animation: fadeInUp 0.8s ease-out 0.2s forwards;
        }

        .hero-subtitle {
            animation: fadeInUp 0.8s ease-out 0.5s forwards;
        }

        .hero-buttons {
            animation: fadeInUp 0.8s ease-out 0.8s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="h-screen w-full overflow-hidden">
        <div class="absolute inset-0 z-0">
            @php
                $heroImage = \App\Models\Image::where('is_hero', true)->first();
            @endphp
            
            @if($heroImage)
                <img src="{{ Storage::url($heroImage->path) }}"
                     alt="{{ $heroImage->title }}"
                     class="h-full w-full object-cover object-center">
            @else
                <div class="h-full w-full bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900"></div>
            @endif

            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/80"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex h-5/6 items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="text-center w-full max-w-4xl">
                <h1 class="hero-title text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight text-white mb-4 sm:mb-6 leading-tight">
                    Selamat Datang di<br>
                    <span class="text-indigo-400">Karang Taruna Desa Sangubanyu</span>
                </h1>
                <p class="hero-subtitle mx-auto mt-4 sm:mt-6 max-w-2xl text-base sm:text-lg md:text-xl text-gray-200 mb-6 sm:mb-8 px-4">
                    Wadah pengembangan generasi muda yang berakhlak, kreatif, dan peduli terhadap masyarakat
                </p>

                <div class="hero-buttons flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                    <a href="/posts"
                       class="rounded-lg bg-indigo-600 px-6 sm:px-8 py-3 text-sm sm:text-base font-semibold text-white shadow-lg hover:bg-indigo-700 transition-all hover:scale-105 w-full sm:w-auto">
                        Lihat Kegiatan
                    </a>
                    <a href="/about"
                       class="rounded-lg bg-white/10 backdrop-blur-sm px-6 sm:px-8 py-3 text-sm sm:text-base font-semibold text-white border-2 border-white/20 hover:bg-white/20 transition-all hover:scale-105 w-full sm:w-auto">
                        Tentang Kami
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-6 sm:bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
            <a href="#content" class="text-white">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Content Section -->
    <div id="content" class="bg-gray-900">

        <!-- Gallery Carousel Section -->
        <div class="gallery-section mx-auto max-w-7xl px-4 py-12 sm:py-16 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4">
                    Galeri Kegiatan
                </h2>
                <p class="text-gray-400 text-base sm:text-lg px-4">
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
                    <div class="overflow-hidden rounded-xl sm:rounded-2xl">
                        <div id="gallery-carousel" class="flex transition-transform duration-500 ease-out">
                            @foreach ($galleryImages as $image)
                                <div class="min-w-full flex-shrink-0">
                                    <div class="relative h-[350px] sm:h-[300px] md:h-[500px] group overflow-hidden">
                                        <img src="{{ Storage::url($image->path) }}"
                                             alt="{{ $image->title }}"
                                             class="w-full h-full object-cover object-center">
                                        
                                        <!-- Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                                            <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 md:p-8">
                                                <h3 class="text-white font-bold text-lg sm:text-xl md:text-2xl mb-1 sm:mb-2">{{ $image->title }}</h3>
                                                @if($image->description)
                                                    <p class="text-gray-300 text-sm sm:text-base line-clamp-2 sm:line-clamp-none">{{ $image->description }}</p>
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
                                class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 sm:p-3 rounded-full transition backdrop-blur-sm z-10">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button id="next-btn" 
                                class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 sm:p-3 rounded-full transition backdrop-blur-sm z-10">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <!-- Dots Indicator -->
                        <div class="flex justify-center gap-1.5 sm:gap-2 mt-4 sm:mt-6">
                            @foreach ($galleryImages as $index => $image)
                                <button class="carousel-dot w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-indigo-600 w-6 sm:w-8' : 'bg-gray-600' }}" 
                                        data-index="{{ $index }}"
                                        aria-label="Go to slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-12 px-4">
                    <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-400 text-base sm:text-lg">Belum ada gambar dalam galeri.</p>
                </div>
            @endif
        </div>

        <!-- Blog Highlights Section -->
        <div class="blog-section mx-auto max-w-7xl px-4 py-12 sm:pt-2 sm:pb-16 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4">
                    Kegiatan Terbaru
                </h2>
                <p class="text-gray-400 text-base sm:text-lg px-4">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-8 sm:mb-12">
                    @foreach ($latestPosts as $post)
                        <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-2xl hover:scale-105 transition-all duration-300 group">
                            <!-- Post Image -->
                            @if($post->image)
                                <div class="relative h-48 sm:h-56 overflow-hidden">
                                    <img src="{{ Storage::url($post->image) }}" 
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                </div>
                            @else
                                <div class="relative h-48 sm:h-56 bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 sm:w-20 sm:h-20 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Post Content -->
                            <div class="p-4 sm:p-6">
                                <!-- Category Badge -->
                                <span class="inline-block px-2.5 sm:px-3 py-1 text-xs font-semibold text-indigo-400 bg-indigo-500/10 rounded-full mb-2 sm:mb-3">
                                    {{ $post->category->activity }}
                                </span>

                                <!-- Title -->
                                <h3 class="text-lg sm:text-xl font-bold text-white mb-2 sm:mb-3 line-clamp-2 group-hover:text-indigo-400 transition">
                                    {{ $post->title }}
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-gray-400 text-sm mb-3 sm:mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($post->body), 120) }}
                                </p>

                                <!-- Meta Info -->
                                <div class="flex items-center justify-between pt-3 sm:pt-4 border-t border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <img class="w-7 h-7 sm:w-8 sm:h-8 rounded-full" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($post->author_name) }}&background=6366f1&color=fff" 
                                             alt="{{ $post->author_name }}">
                                        <div>
                                            <p class="text-xs text-gray-400 truncate max-w-[120px] sm:max-w-none">{{ $post->author_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('post.show', $post->id) }}" 
                                       class="text-indigo-400 hover:text-indigo-300 transition flex-shrink-0">
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
                <div class="text-center px-4">
                    <a href="/posts" 
                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-xl transition-all hover:scale-105 shadow-lg text-sm sm:text-base w-full sm:w-auto justify-center">
                        <span>Lihat Semua Kegiatan</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-12 px-4">
                    <p class="text-gray-400 text-base sm:text-lg">Belum ada kegiatan yang dipublikasikan.</p>
                </div>
            @endif
        </div>

        {{-- structure --}}
        <div class="leadership-section mx-12 mb-20 max-w-7xl px-4 py-12 rounded-xl sm:py-16 sm:px-6 lg:px-8 border-2 border-red-500">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4">
                    Pimpinan Kami
                </h2>
                <p class="text-gray-400 text-base sm:text-lg px-4">
                    Pemimpin yang membawa visi dan misi Karang Taruna
                </p>
            </div>

            @php
                // Get all active structure positions ordered
                $structures = \App\Models\StructurePosition::where('is_active', true)
                    ->orderBy('order')
                    ->orderBy('created_at', 'asc')
                    ->get();
                
                // Find Ketua (not Wakil Ketua)
                $ketua = $structures->first(function ($item) {
                    return stripos($item->position, 'Ketua') !== false && 
                           stripos($item->position, 'Wakil') === false;
                });
                
                // Find Wakil Ketua
                $wakilKetua = $structures->first(function ($item) {
                    return stripos($item->position, 'Wakil') !== false;
                });
            @endphp

            @if($ketua || $wakilKetua)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-8 max-w-4xl mx-auto">
                    @if($ketua)
                        <div class="bg-gray-800 rounded-2xl overflow-hidden hover:shadow-2xl mx-12 hover:scale-105 transition-all duration-300 group border-2 border-indigo-500/50">
                            <div class="relative h-64 sm:h-80 overflow-hidden">
                                @if($ketua->photo)
                                    <img src="{{ Storage::url($ketua->photo) }}" 
                                         alt="{{ $ketua->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center">
                                        <svg class="w-24 h-24 sm:w-32 sm:h-32 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6">
                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-indigo-600 text-white rounded-full mb-2">
                                            {{ $ketua->position }}
                                        </span>
                                        <h3 class="text-white font-bold text-xl sm:text-2xl mb-2">{{ $ketua->name }}</h3>
                                        @if($ketua->phone)
                                            <a href="tel:{{ $ketua->phone }}" 
                                               class="text-gray-300 hover:text-indigo-400 text-sm flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                {{ $ketua->phone }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($wakilKetua)
                        <div class="bg-gray-800 rounded-2xl overflow-hidden hover:shadow-2xl mx-12 hover:scale-105 transition-all duration-300 group border-2 border-purple-500/50">
                            <div class="relative h-64 sm:h-80 overflow-hidden">
                                @if($wakilKetua->photo)
                                    <img src="{{ Storage::url($wakilKetua->photo) }}" 
                                         alt="{{ $wakilKetua->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                                        <svg class="w-24 h-24 sm:w-32 sm:h-32 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6">
                                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-purple-600 text-white rounded-full mb-2">
                                            {{ $wakilKetua->position }}
                                        </span>
                                        <h3 class="text-white font-bold text-xl sm:text-2xl mb-2">{{ $wakilKetua->name }}</h3>
                                        @if($wakilKetua->phone)
                                            <a href="tel:{{ $wakilKetua->phone }}" 
                                               class="text-gray-300 hover:text-purple-400 text-sm flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                {{ $wakilKetua->phone }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- View Structure Button -->
                <div class="text-center">
                    <a href="/struktur" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-xl transition-all hover:scale-105 shadow-lg text-sm sm:text-base w-full sm:w-auto justify-center">
                        <span>Lihat Struktur Lengkap</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-12 px-4">
                    <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-gray-400 text-base sm:text-lg">Informasi pimpinan belum tersedia.</p>
                </div>
            @endif
        </div>

        {{-- Contact Information Section --}}
        <div class="contact-section mx-auto max-w-7xl px-4 py-12 sm:py-16 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 sm:mb-4">
                    Hubungi Kami
                </h2>
                <p class="text-gray-400 text-base sm:text-lg px-4">
                    Jangan ragu untuk menghubungi kami melalui platform berikut
                </p>
            </div>

            @php
                $contacts = \App\Models\Contact::where('is_active', true)
                    ->orderBy('order')
                    ->orderBy('created_at', 'asc')
                    ->get();
            @endphp

            @if ($contacts->count() > 0)
                <div class="max-w-4xl mx-auto grid gap-6 sm:gap-8 md:grid-cols-2 mb-8">
                    @foreach ($contacts as $contact)
                        <a href="{{ $contact->link }}" 
                           target="_blank"
                           class="group relative bg-gray-800 rounded-2xl p-6 sm:p-8 hover:shadow-2xl hover:scale-105 transition-all duration-300 border-2 border-transparent hover:border-{{ $contact->type === 'whatsapp' ? 'green' : 'purple' }}-500 overflow-hidden">
                            
                            <!-- Gradient Background Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $contact->type === 'whatsapp' ? 'from-green-500/5 to-transparent' : 'from-purple-500/5 via-pink-500/5 to-orange-500/5' }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <div class="relative">
                                <div class="flex items-start gap-4 mb-4">
                                    @if($contact->type === 'whatsapp')
                                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg flex-shrink-0">
                                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg flex-shrink-0">
                                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-3 py-1 text-xs font-semibold {{ $contact->type === 'whatsapp' ? 'bg-green-500' : 'bg-gradient-to-r from-purple-500 to-pink-500' }} text-white rounded-full">
                                                {{ $contact->type === 'whatsapp' ? 'WhatsApp' : 'Instagram' }}
                                            </span>
                                        </div>
                                        <h3 class="text-white font-bold text-lg sm:text-xl mb-2 group-hover:text-{{ $contact->type === 'whatsapp' ? 'green' : 'purple' }}-400 transition">
                                            {{ $contact->label }}
                                        </h3>
                                        <p class="text-gray-400 text-sm sm:text-base mb-3">{{ $contact->value }}</p>
                                        <div class="flex items-center gap-2 text-{{ $contact->type === 'whatsapp' ? 'green' : 'purple' }}-400 text-sm font-medium">
                                            <span class="text-white">Klik untuk menghubungi</span>
                                            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Decorative Elements -->
                                <div class="absolute top-0 right-0 w-32 h-32 {{ $contact->type === 'whatsapp' ? 'bg-green-500' : 'bg-purple-500' }}/5 rounded-full blur-3xl -z-10"></div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- CTA Button -->
                <div class="text-center">
                    <a href="/contact" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-xl transition-all hover:scale-105 shadow-lg text-sm sm:text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Lihat Semua Kontak</span>
                    </a>
                </div>
            @else
                <div class="text-center py-12 px-4">
                    <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-400 text-base sm:text-lg">Informasi kontak belum tersedia.</p>
                </div>
            @endif
        </div>

    </div>
    <script src="{{ asset('js/home.js') }}"></script>
</x-layout>