<x-layout>
    <x-slot:title>Edit Dokumen</x-slot:title>

    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Edit Dokumen</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Current File Info -->
            <div class="bg-gray-700/50 rounded-lg p-4">
                <h3 class="text-white font-semibold mb-2">File Saat Ini:</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white">{{ $document->file_name }}</p>
                        <p class="text-gray-400 text-sm">{{ strtoupper($document->file_type) }} • {{ $document->formatted_file_size }}</p>
                    </div>
                    <a href="{{ Storage::url($document->file_path) }}" 
                       target="_blank"
                       class="ml-auto text-indigo-400 hover:text-indigo-300 text-sm">
                        Lihat File
                    </a>
                </div>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-white mb-2 font-medium">Judul Dokumen *</label>
                <input type="text" name="title" value="{{ old('title', $document->title) }}" required
                    placeholder="e.g., Surat Keputusan Pengurus 2024"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-white mb-2 font-medium">Upload File Baru (optional)</label>
                <input type="file" name="file"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Kosongkan jika tidak ingin mengganti file. Max: 10MB</p>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-white mb-2 font-medium">Kategori</label>
                <div class="flex gap-2">
                    <input type="text" 
                           name="category" 
                           value="{{ old('category', $document->category) }}"
                           list="category-suggestions"
                           placeholder="e.g., Surat Keputusan, Laporan, Proposal"
                           class="flex-1 bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    
                    <datalist id="category-suggestions">
                        @foreach($existingCategories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-white mb-2 font-medium">Deskripsi</label>
                <textarea name="description" rows="4"
                    placeholder="Deskripsi singkat tentang dokumen ini..."
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $document->description) }}</textarea>
            </div>

            <!-- Order -->
            <div>
                <label class="block text-white mb-2 font-medium">Urutan Tampil (Order)</label>
                <input type="number" name="order" value="{{ old('order', $document->order) }}"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Published Status -->
            <div class="p-4 bg-indigo-500/10 border border-indigo-500 rounded">
                <label class="flex items-center text-white">
                    <input type="checkbox" name="is_published" value="1" {{ $document->is_published ? 'checked' : '' }}
                        class="mr-2 rounded bg-gray-700 border-gray-600">
                    <div>
                        <span class="font-semibold">Publish Dokumen</span>
                        <p class="text-sm text-gray-300 mt-1">Centang untuk menampilkan dokumen di halaman publik</p>
                    </div>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                    Update Dokumen
                </button>
                <a href="{{ route('admin.documents.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layout>