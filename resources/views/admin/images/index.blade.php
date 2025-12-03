<x-layout>
    <x-slot:title>Manage Images</x-slot:title>

    <div class="py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Image Gallery Management</h2>
            <a href="{{ route('admin.images.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Upload New Image
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($images as $image)
                <div class="bg-gray-800 rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->title }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-white font-semibold mb-2">{{ $image->title }}</h3>
                        <p class="text-gray-400 text-sm mb-3">{{ Str::limit($image->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span
                                class="px-2 py-1 text-xs rounded {{ $image->is_active ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                {{ $image->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.images.edit', $image) }}"
                                    class="text-blue-500 hover:text-blue-400">Edit</a>
                                <form action="{{ route('admin.images.destroy', $image) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-12">
                    No images uploaded yet.
                </div>
            @endforelse
        </div>
    </div>
</x-layout>