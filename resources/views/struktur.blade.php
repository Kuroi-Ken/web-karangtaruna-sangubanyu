<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="py-12">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-white mb-4">
                Struktur Organisasi
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Pengurus Karang Taruna Desa Sangubanyu
            </p>
        </div>

        @if ($structures->count() > 0)
            <div class="max-w-6xl mx-auto">
                @foreach ($structures as $index => $structure)
                    @if($index === 0)
                        <div class="flex justify-center mb-12">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                                <div class="relative bg-gray-800 rounded-xl p-6 w-80">
                                    <div class="flex flex-col items-center">
                                        @if($structure->photo)
                                            <img src="{{ Storage::url($structure->photo) }}" 
                                                 alt="{{ $structure->name }}"
                                                 class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 mb-4">
                                        @else
                                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-4 border-4 border-indigo-500">
                                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <span class="text-indigo-400 font-semibold text-sm mb-2">
                                            {{ $structure->position }}
                                        </span>
                                        <h3 class="text-white font-bold text-xl text-center mb-2">
                                            {{ $structure->name }}
                                        </h3>
                                        
                                        @if($structure->phone)
                                            <a href="tel:{{ $structure->phone }}" 
                                               class="text-gray-400 hover:text-indigo-400 text-sm flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                {{ $structure->phone }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mb-8">
                            <div class="w-0.5 h-12 bg-gradient-to-b from-indigo-500 to-transparent"></div>
                        </div>
                    @endif
                    @if($index === 1)
                        <div class="flex justify-center mb-12">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition duration-300"></div>
                                <div class="relative bg-gray-800 rounded-xl p-6 w-80">
                                    <div class="flex flex-col items-center">
                                        @if($structure->photo)
                                            <img src="{{ Storage::url($structure->photo) }}" 
                                                 alt="{{ $structure->name }}"
                                                 class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500 mb-4">
                                        @else
                                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-4 border-4 border-indigo-500">
                                                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <span class="text-indigo-400 font-semibold text-sm mb-2">
                                            {{ $structure->position }}
                                        </span>
                                        <h3 class="text-white font-bold text-xl text-center mb-2">
                                            {{ $structure->name }}
                                        </h3>
                                        
                                        @if($structure->phone)
                                            <a href="tel:{{ $structure->phone }}" 
                                               class="text-gray-400 hover:text-indigo-400 text-sm flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                {{ $structure->phone }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-center mb-8">
                            <div class="w-0.5 h-12 bg-gradient-to-b from-indigo-500 to-transparent"></div>
                        </div>
                    @endif
                @endforeach
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($structures as $index => $structure)
                        @if($index > 1)
                            <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-xl hover:scale-105 transition-all duration-300 border border-gray-700 hover:border-indigo-500">
                                <div class="relative">
                                    @if($structure->photo)
                                        <img src="{{ Storage::url($structure->photo) }}" 
                                             alt="{{ $structure->name }}"
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                            <svg class="w-20 h-20 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Badge Position -->
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-full">
                                            {{ $structure->position }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-5">
                                    <h3 class="text-white font-bold text-lg mb-2 text-center">
                                        {{ $structure->name }}
                                    </h3>
                                    
                                    @if($structure->phone)
                                        <div class="flex justify-center">
                                            <a href="tel:{{ $structure->phone }}" 
                                               class="text-gray-400 hover:text-indigo-400 text-sm flex items-center gap-2 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                {{ $structure->phone }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-800 rounded-full mb-6">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">
                    Struktur Organisasi Belum Tersedia
                </h3>
                <p class="text-gray-400">
                    Informasi struktur organisasi akan segera diperbarui.
                </p>
            </div>
        @endif

    </div>
</x-layout>