<x-layout>
    <x-slot:title>Dokumen</x-slot:title>

    <div class="py-6">
        <x-admin-menu />
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Manajemen Menu Dokumen</h2>
            <a href="{{ route('admin.documents.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                + Tambah Dokumen
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

        <!-- Filter Section -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.documents.index') }}" class="flex gap-4 flex-wrap">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari dokumen..." 
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="min-w-[150px]">
                    <select name="category" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-[150px]">
                    <select name="status" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Dipublikasi</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draf</option>
                    </select>
                </div>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Filter
                </button>
                @if(request()->has('search') || request()->has('category') || request()->has('status'))
                    <a href="{{ route('admin.documents.index') }}" 
                       class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Documents Table -->
        <!-- Desktop: Tabel Normal, Mobile: Scroll Horizontal -->
        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <!-- Wrapper untuk scroll horizontal di mobile -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase whitespace-nowrap">File Info</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($documents as $document)
                            <tr class="hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br 
                                            @if(strtolower($document->file_type) === 'pdf') from-red-600 to-red-700
                                            @elseif(in_array(strtolower($document->file_type), ['doc', 'docx'])) from-blue-600 to-blue-700
                                            @elseif(in_array(strtolower($document->file_type), ['xls', 'xlsx'])) from-green-600 to-green-700
                                            @else from-gray-600 to-gray-700
                                            @endif
                                            rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-white font-medium whitespace-nowrap">{{ Str::limit($document->title, 40) }}</div>
                                            @if($document->description)
                                                <div class="text-gray-400 text-sm whitespace-nowrap">{{ Str::limit($document->description, 60) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($document->category)
                                        <span class="px-2 py-1 text-xs rounded bg-indigo-500/10 text-indigo-400 whitespace-nowrap inline-block">
                                            {{ $document->category }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-300 text-sm">
                                    <div class="whitespace-nowrap">{{ strtoupper($document->file_type) }}</div>
                                    <div class="text-gray-500 whitespace-nowrap">{{ $document->formatted_file_size }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 text-xs rounded {{ $document->is_published ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-500' }} whitespace-nowrap inline-block">
                                        {{ $document->is_published ? 'Dipublikasi' : 'Draf' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex gap-3 justify-end whitespace-nowrap">
                                        <a href="{{ Storage::url($document->file_path) }}" 
                                        target="_blank"
                                        class="text-green-400 hover:text-green-300">Lihat</a>
                                        <a href="{{ route('admin.documents.edit', $document) }}"
                                            class="text-blue-400 hover:text-blue-300">Edit</a>
                                        <form action="{{ route('admin.documents.destroy', $document) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    Belum ada dokumen.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($documents->isNotEmpty())
            <div class="mt-6 text-gray-400 text-sm">
                Menampilkan {{ $documents->count() }} Dokumen
            </div>
        @endif
        @if($documents->hasPages())
            <div class="mt-6">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</x-layout>