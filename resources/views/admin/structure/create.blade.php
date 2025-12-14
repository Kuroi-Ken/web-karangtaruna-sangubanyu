<x-layout>
    <x-slot:title>Tambah Jabatan Baru</x-slot:title>

    <div class="max-w-2xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Tambah Jabatan Baru</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.structure.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Jabatan *</label>
                <input type="text" name="position" value="{{ old('position') }}" required
                    placeholder="e.g., Ketua, Wakil Ketua, Sekretaris"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Nama *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Nama lengkap"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Nomor WA</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    placeholder="08123456789"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Foto Profil</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Max size: 2MB. Formats: JPEG, PNG, JPG</p>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Urutan: </label>
                <input type="number" name="order" value="{{ old('order', 0) }}"
                    placeholder="0"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Semakin Kecil Angka Akan Di Tampilkan Di Urutan Teratas (Urutan 0 = Paling Atas)</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center text-white">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="mr-2 rounded bg-gray-700 border-gray-600">
                    Aktif (Tampilkan Di Menu Struktur)
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                    Tambah Jabatan
                </button>
                <a href="{{ route('admin.structure.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layout>