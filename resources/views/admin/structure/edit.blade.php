<x-layout>
    <x-slot:title>Edit Structure Position</x-slot:title>

    <div class="max-w-2xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Edit Structure Position</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.structure.update', $structure) }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-6">
            @csrf
            @method('PUT')

            @if($structure->photo)
                <div class="mb-4">
                    <label class="block text-white mb-2 font-medium">Current Photo</label>
                    <img src="{{ Storage::url($structure->photo) }}" 
                         alt="{{ $structure->name }}"
                         class="w-48 h-48 object-cover rounded">
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Position/Jabatan *</label>
                <input type="text" name="position" value="{{ old('position', $structure->position) }}" required
                    placeholder="e.g., Ketua, Wakil Ketua, Sekretaris"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Name *</label>
                <input type="text" name="name" value="{{ old('name', $structure->name) }}" required
                    placeholder="Nama lengkap"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $structure->phone) }}"
                    placeholder="08123456789"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Change Photo (optional)</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Leave empty to keep current photo</p>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Display Order</label>
                <input type="number" name="order" value="{{ old('order', $structure->order) }}"
                    placeholder="0"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Lower number = displayed first (0 = top)</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center text-white">
                    <input type="checkbox" name="is_active" value="1" {{ $structure->is_active ? 'checked' : '' }}
                        class="mr-2 rounded bg-gray-700 border-gray-600">
                    Active (Show on public page)
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                    Update Position
                </button>
                <a href="{{ route('admin.structure.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layout>