<x-layout>
    <x-slot:title>Edit Gambar</x-slot:title>

    <div class="max-w-2xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Edit Gambar</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.images.update', $image) }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-white mb-2">Gambar Saat Ini</label>
                <img src="{{ Storage::url($image->path) }}" alt="{{ $image->title }}"
                    class="w-full max-w-md h-48 object-cover rounded">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2">Judul *</label>
                <input type="text" name="title" value="{{ old('title', $image->title) }}" required
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2">Ganti Gambar</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Biarkan Kosong Jika Tidak Ingin Diubah</p>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $image->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2">Urutan</label>
                <input type="number" name="order" value="{{ old('order', $image->order) }}"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="flex items-center text-white">
                    <input type="checkbox" name="is_active" value="1" {{ $image->is_active ? 'checked' : '' }}
                        class="mr-2 rounded bg-gray-700 border-gray-600">
                    Aktif (Ditampilkan Di Galeri)
                </label>
            </div>

            <div class="mb-6 p-4 bg-indigo-500/10 border border-indigo-500 rounded">
                <label class="flex items-start text-white">
                    <input type="checkbox" name="is_hero" value="1" {{ $image->is_hero ? 'checked' : '' }}
                        class="mr-2 mt-1 rounded bg-gray-700 border-gray-600">
                    <div>
                        <span class="font-semibold">Buat Menjadi Background</span>
                        <p class="text-sm text-gray-300 mt-1">Gambar Ini Akan Digunakan Sebagai Background. Hanya 1 Gambar Yang Dapat Disetel menjadi Background.
                        </p>
                    </div>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                    Update Gambar
                </button>
                <a href="{{ route('admin.images.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layout>