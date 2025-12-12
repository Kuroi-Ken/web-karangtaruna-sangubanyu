<x-layout>
    <x-slot:title>Tambah Dokumen</x-slot:title>

    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Tambah Dokumen Baru</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-6 space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-white mb-2 font-medium">Judul Dokumen *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    placeholder="e.g., Surat Keputusan Pengurus 2024"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-white mb-2 font-medium">Upload File *</label>
                <input type="file" name="file" required
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Max size: 10MB. Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX</p>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-white mb-2 font-medium">Kategori</label>
                <div class="flex gap-2">
                    <input type="text" 
                           name="category" 
                           value="{{ old('category') }}"
                           list="category-suggestions"
                           placeholder="e.g., Surat Keputusan, Laporan, Proposal"
                           class="flex-1 bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    
                    <datalist id="category-suggestions">
                        @foreach($existingCategories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                </div>
                <p class="text-gray-400 text-sm mt-1">Pilih dari kategori yang ada atau ketik kategori baru</p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-white mb-2 font-medium">Deskripsi</label>
                <textarea name="description" rows="4"
                    placeholder="Deskripsi singkat tentang dokumen ini..."
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <!-- Order -->
            <div>
                <label class="block text-white mb-2 font-medium">Urutan Tampil (Order)</label>
                <input type="number" name="order" value="{{ old('order', 0) }}"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Angka lebih kecil akan ditampilkan lebih dulu (default: 0)</p>
            </div>

            <!-- Published Status -->
            <div class="p-4 bg-indigo-500/10 border border-indigo-500 rounded">
                <label class="flex items-center text-white">
                    <input type="checkbox" name="is_published" value="1" checked
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
                    Simpan Dokumen
                </button>
                <a href="{{ route('admin.documents.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layout>