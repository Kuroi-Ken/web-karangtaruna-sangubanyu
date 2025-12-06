<x-layout>
    <x-slot:title>Manage Images</x-slot:title>

    <div class="py-6">
        <x-admin-menu />
        
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

        @if (session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search and Filter Form -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.images.index') }}" class="flex gap-4 flex-wrap">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search images by title or description..." 
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="min-w-[150px]">
                    <select name="status" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Search
                </button>
                @if(request('search') || request('status') !== null)
                    <a href="{{ route('admin.images.index') }}" 
                       class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($images as $image)
                <div class="bg-gray-800 rounded-lg overflow-hidden hover:ring-2 hover:ring-indigo-500 transition">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $image->title }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-white font-semibold flex-1">{{ $image->title }}</h3>
                            <span class="text-xs text-gray-500 ml-2">Order: {{ $image->order }}</span>
                        </div>
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
                    @if(request('search') || request('status') !== null)
                        No images found matching your search criteria.
                    @else
                        No images uploaded yet.
                    @endif
                </div>
            @endforelse
        </div>

        @if($images->isNotEmpty())
            <div class="mt-6 text-gray-400 text-sm">
                Showing {{ $images->count() }} image(s)
            </div>
        @endif
    </div>
</x-layout>