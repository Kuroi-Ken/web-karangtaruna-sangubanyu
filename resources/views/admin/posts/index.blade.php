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
    <div class="sticky top-16 z-10 bg-gray-900/95 backdrop-blur-sm -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-4 mb-8 shadow-lg border-b border-gray-700">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="space-y-3">

            <!-- Main Search (Always Visible) -->
            <div class="flex items-center gap-3">
                <div class="relative flex-1">
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search posts..." 
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 pl-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-gray-400">
                    
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition text-sm whitespace-nowrap">
                    Search
                </button>

                @if(request('search') || request('category') || request('date'))
                    <a href="{{ route('admin.posts.index') }}" 
                    class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition text-sm whitespace-nowrap">
                        Clear
                    </a>
                @endif
            </div>

            <!-- Advanced Filters Toggle -->
            <div class="flex items-center justify-between pt-2 border-t border-gray-700">
                <button type="button" 
                        id="toggleAdvancedAdmin"
                        class="flex items-center gap-2 text-gray-400 hover:text-white transition text-sm">
                    <svg id="advancedIconAdmin" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <span>Advanced Filters</span>
                </button>

                @if(request('category') || request('date'))
                    <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-xs font-medium">
                        {{ collect([request('category'), request('date')])->filter()->count() }} filter(s) active
                    </span>
                @endif
            </div>

            <!-- Advanced Filters (Hidden by Default) -->
            <div id="advancedFiltersAdmin" class="hidden space-y-3 pt-3 border-t border-gray-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-gray-400 text-xs mb-1">Category</label>
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

                    <!-- Date Filter -->
                    <div>
                        <label class="block text-gray-400 text-xs mb-1">Date</label>
                        <input type="date"
                            name="date"
                            value="{{ request('date') }}"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Apply Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition text-sm">
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if(request('search') || request('category') || request('date'))
                <div class="pt-3 border-t border-gray-700">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-gray-400 text-xs">Active filters:</span>

                        @if(request('search'))
                            <span class="bg-indigo-500/20 text-indigo-300 px-3 py-1 rounded-full text-xs">
                                "{{ Str::limit(request('search'), 20) }}"
                            </span>
                        @endif

                        @if(request('category'))
                            @php
                                $selectedCategory = $categories->firstWhere('id', request('category'));
                            @endphp
                            <span class="bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full text-xs">
                                {{ $selectedCategory->activity ?? 'Category' }}
                            </span>
                        @endif

                        @if(request('date'))
                            <span class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-xs">
                                {{ \Carbon\Carbon::parse(request('date'))->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif

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

<script>
    // Toggle Advanced Filters for Admin
    const toggleBtnAdmin = document.getElementById('toggleAdvancedAdmin');
    const advancedFiltersAdmin = document.getElementById('advancedFiltersAdmin');
    const advancedIconAdmin = document.getElementById('advancedIconAdmin');

    if (toggleBtnAdmin) {
        toggleBtnAdmin.addEventListener('click', () => {
            advancedFiltersAdmin.classList.toggle('hidden');
            advancedIconAdmin.classList.toggle('rotate-180');
        });
    }

    // Auto-open if any advanced filter is active
    @if(request('category') || request('date'))
        if (advancedFiltersAdmin) {
            advancedFiltersAdmin.classList.remove('hidden');
            advancedIconAdmin.classList.add('rotate-180');
        }
    @endif
</script>