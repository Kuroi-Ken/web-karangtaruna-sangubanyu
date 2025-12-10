<x-layout>
    <x-slot:title>Manage Posts</x-slot:title>

    <div class="py-4 sm:py-6">
        <x-admin-menu />
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-white">Blog Posts Management</h2>
            <a href="{{ route('admin.posts.create') }}"
                class="w-full sm:w-auto text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition text-sm sm:text-base">
                + Create New Post
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filter Form -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="space-y-3">
                <!-- Search Input -->
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search posts..." 
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-gray-400">
                </div>

                <!-- Category Filter -->
                <div>
                    <select name="category" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->activity }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition text-sm">
                        Search
                    </button>
                    @if(request('search') || request('category'))
                        <a href="{{ route('admin.posts.index') }}" 
                           class="flex-1 text-center bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition text-sm">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block bg-gray-800 rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Author
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-gray-700/50">
                            <td class="px-6 py-4">
                                <div class="text-white font-medium">{{ Str::limit($post->title, 50) }}</div>
                                <div class="text-gray-400 text-sm">{{ Str::limit($post->body, 80) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded bg-indigo-500/10 text-indigo-400">
                                    {{ $post->category->activity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">
                                {{ $post->author_name ?? $post->author->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-sm">
                                {{ $post->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex gap-3 justify-end">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                        class="text-blue-400 hover:text-blue-300">Edit</a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                @if(request('search') || request('category'))
                                    No posts found matching your search criteria.
                                @else
                                    No posts found. Create your first post!
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden space-y-4">
            @forelse ($posts as $post)
                <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700/50 transition">
                    <!-- Post Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-white font-semibold text-base mb-1 line-clamp-2">
                                {{ $post->title }}
                            </h3>
                            <span class="inline-block px-2 py-1 text-xs rounded bg-indigo-500/10 text-indigo-400">
                                {{ $post->category->activity }}
                            </span>
                        </div>
                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" 
                                 alt="{{ $post->title }}"
                                 class="w-16 h-16 rounded object-cover ml-3 flex-shrink-0">
                        @endif
                    </div>

                    <!-- Post Excerpt -->
                    <p class="text-gray-400 text-sm mb-3 line-clamp-2">
                        {{ Str::limit($post->body, 100) }}
                    </p>

                    <!-- Post Meta -->
                    <div class="flex items-center text-xs text-gray-400 mb-3 pb-3 border-b border-gray-700">
                        <div class="flex items-center gap-2 flex-1">
                            <img class="w-6 h-6 rounded-full" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode($post->author_name ?? $post->author->name) }}&background=6366f1&color=fff" 
                                 alt="{{ $post->author_name ?? $post->author->name }}">
                            <span class="truncate">{{ $post->author_name ?? $post->author->name }}</span>
                        </div>
                        <span class="text-gray-500">{{ $post->created_at->format('M d, Y') }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}"
                            class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this post?')"
                              class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm font-medium transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-gray-800 rounded-lg p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-400">
                        @if(request('search') || request('category'))
                            No posts found matching your search criteria.
                        @else
                            No posts found. Create your first post!
                        @endif
                    </p>
                    @if(!request('search') && !request('category'))
                        <a href="{{ route('admin.posts.create') }}" 
                           class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                            Create First Post
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        @if($posts->isNotEmpty())
            <div class="mt-4 text-gray-400 text-sm">
                Showing {{ $posts->count() }} post(s)
            </div>
        @endif
    </div>
</x-layout>