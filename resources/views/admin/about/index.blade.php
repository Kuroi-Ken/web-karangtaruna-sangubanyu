<x-layout>
    <x-slot:title>Tentang Kami</x-slot:title>

    <div class="py-6">
        <x-admin-menu />
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Manajemen Menu Tentang Kami</h2>
            <a href="{{ route('admin.about.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Buat Halaman Baru
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Current Active About -->
        @if(isset($activeAbout) && $activeAbout)
            <div class="bg-gradient-to-r from-indigo-500/20 to-purple-500/20 border border-indigo-500 rounded-lg p-6 mb-6">
                <div class="flex items-start gap-6">
                    @if($activeAbout->image)
                        <img src="{{ Storage::url($activeAbout->image) }}" 
                             alt="{{ $activeAbout->title }}"
                             class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                    @endif
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-white font-semibold">Halaman Aktif Saat ini</span>
                        </div>
                        <h3 class="text-white font-bold text-xl mb-2">{{ $activeAbout->title }}</h3>
                        <p class="text-gray-300 text-sm mb-3 line-clamp-2">{{ $activeAbout->description }}</p>
                        <div class="flex gap-3">
                            <a href="{{ route('admin.about.edit', $activeAbout) }}" 
                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                                Edit
                            </a>
                            <a href="/about" 
                               target="_blank"
                               class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
                                Lihat Preview
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-yellow-500/10 border border-yellow-500 text-yellow-500 px-4 py-3 rounded mb-6">
                Tidak Ada Halaman Tentang Kami. Ayo Buat Baru
            </div>
        @endif

        <!-- All About Pages -->
        <div class="grid grid-cols-1 gap-6">
            @forelse ($about as $item)
                <div class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-indigo-500 transition {{ $item->is_active ? 'ring-2 ring-indigo-500' : '' }}">
                    <div class="flex flex-col md:flex-row gap-4 p-6">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" 
                                 alt="{{ $item->title }}"
                                 class="w-full md:w-48 h-48 object-cover rounded-lg">
                        @endif
                        
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-white font-bold text-xl mb-1">{{ $item->title }}</h3>
                                    @if($item->is_active)
                                        <span class="px-2 py-1 text-xs rounded bg-green-500 text-white font-semibold">
                                            Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-gray-400 text-sm mb-3 line-clamp-3">{{ $item->description }}</p>
                            
                            <div class="mb-3">
                                <h4 class="text-indigo-400 font-semibold text-sm mb-1">Visi:</h4>
                                <p class="text-gray-400 text-sm line-clamp-2">{{ $item->vision }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="text-indigo-400 font-semibold text-sm mb-1">Misi:</h4>
                                <ul class="text-gray-400 text-sm space-y-1">
                                    @foreach(array_slice($item->mission ?? [], 0, 3) as $mission)
                                        <li class="flex items-start gap-2">
                                            <span class="text-indigo-400 mt-1">•</span>
                                            <span class="line-clamp-1">{{ $mission }}</span>
                                        </li>
                                    @endforeach
                                    @if(count($item->mission ?? []) > 3)
                                        <li class="text-gray-500 text-xs">+{{ count($item->mission) - 3 }} Selebihnya...</li>
                                    @endif
                                </ul>
                            </div>
                            
                            <div class="flex gap-2 pt-3 border-t border-gray-700">
                                <a href="{{ route('admin.about.edit', $item) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                    Edit
                                </a>
                                @if(!$item->is_active)
                                    <form action="{{ route('admin.about.destroy', $item) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-xl">Belum ada Halaman Tentang Kami</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>