<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if($about)
        <div class="py-12">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    {{ $about->title }}
                </h1>
            </div>

            <!-- Image Section (if exists) -->
            @if($about->image)
                <div class="mb-12">
                    <img src="{{ Storage::url($about->image) }}" 
                         alt="{{ $about->title }}"
                         class="w-full max-w-4xl mx-auto h-64 sm:h-96 object-cover rounded-2xl shadow-2xl">
                </div>
            @endif

            <!-- Description Section -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-gray-800 rounded-2xl p-6 sm:p-8 border border-gray-700">
                    <p class="text-gray-300 text-lg leading-relaxed whitespace-pre-line">
                        {{ $about->description }}
                    </p>
                </div>
            </div>

            <!-- Vision & Mission Section -->
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                <!-- Vision -->
                <div class="bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-2xl p-6 sm:p-8 border border-indigo-500/50">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Visi</h2>
                    </div>
                    <p class="text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $about->vision }}
                    </p>
                </div>

                <!-- Mission -->
                <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl p-6 sm:p-8 border border-purple-500/50">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Misi</h2>
                    </div>
                    <ul class="space-y-3">
                        @foreach($about->mission as $index => $missionItem)
                            <li class="flex items-start gap-3 text-gray-300">
                                <span class="flex-shrink-0 w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <span class="flex-1 leading-relaxed">{{ $missionItem }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Additional Info Section (Optional) -->
            <div class="max-w-4xl mx-auto mt-12">
                <div class="bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-pink-500/10 rounded-2xl p-6 sm:p-8 border border-indigo-500/30">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-white mb-4">
                            Mari Bergabung Bersama Kami
                        </h3>
                        <p class="text-gray-300 mb-6">
                            Karang Taruna Desa Sangubanyu selalu terbuka untuk anggota baru yang ingin berkontribusi dalam membangun masyarakat yang lebih baik.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="/contact" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-lg transition-all hover:scale-105 shadow-lg">
                                Hubungi Kami
                            </a>
                            <a href="/posts" 
                               class="bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold px-8 py-3 rounded-lg transition-all hover:scale-105 border border-white/20">
                                Lihat Kegiatan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="py-16 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-800 rounded-full mb-6">
                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-white mb-4">
                Informasi Belum Tersedia
            </h2>
            <p class="text-gray-400 mb-6">
                Halaman About sedang dalam proses pembuatan.
            </p>
            <a href="/" 
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition-all hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    @endif
</x-layout>