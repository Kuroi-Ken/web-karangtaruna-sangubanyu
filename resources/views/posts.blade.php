<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Sticky Search Section -->
    <div class="sticky top-16 z-40 bg-gray-900/95 backdrop-blur-sm -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-4 mb-8 shadow-lg border-b border-gray-700">
        <div class="max-w-7xl mx-auto">
            <form method="GET" action="{{ url('/posts') }}" class="space-y-4">

                <!-- Main Search Bar (Always Visible) -->
                <div>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <input type="text" 
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search by title, content, author, or category..."
                                   class="w-full bg-gray-800 text-white rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 placeholder-gray-400 border border-gray-700">

                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition text-sm whitespace-nowrap">
                            Search
                        </button>

                        @if(request('search') || request('category') || request('author') || request('sort'))
                            <a href="{{ url('/posts') }}" 
                               class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition text-sm whitespace-nowrap">
                                Clear
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Advanced Search Toggle Button -->
                <div class="flex items-center justify-between pt-2 border-t border-gray-700">
                    <button type="button" 
                            id="toggleAdvanced"
                            class="flex items-center gap-2 text-gray-400 hover:text-white transition text-sm">
                        <svg id="advancedIcon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <span>Advanced Filters</span>
                    </button>

                    <!-- Active Filters Badge -->
                    @if(request('category') || request('author') || request('sort'))
                        <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 rounded-full text-xs font-medium">
                            {{ collect([request('category'), request('author'), request('sort')])->filter()->count() }} filter(s) active
                        </span>
                    @endif
                </div>

                <!-- Advanced Filters (Hidden by Default) -->
                <div id="advancedFilters" class="hidden space-y-3 pt-3 border-t border-gray-700">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Category Filter -->
                        <div>
                            <label class="block text-gray-400 text-xs mb-1">Category</label>
                            <select name="category" 
                                    class="w-full bg-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 border border-gray-700">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->activity }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Author Filter -->
                        <div>
                            <label class="block text-gray-400 text-xs mb-1">Author</label>
                            <select name="author" 
                                    class="w-full bg-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 border border-gray-700">
                                <option value="">All Authors</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author }}" {{ request('author') == $author ? 'selected' : '' }}>
                                        {{ $author }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Filter -->
                        <div>
                            <label class="block text-gray-400 text-xs mb-1">Sort By</label>
                            <select name="sort" 
                                    class="w-full bg-gray-800 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 border border-gray-700">
                                <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title (A-Z)</option>
                                <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>Author (A-Z)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Apply Filters Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition text-sm">
                            Apply Filters
                        </button>
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if(request('search') || request('category') || request('author') || request('sort'))
                    <div class="pt-3 border-t border-gray-700">
                        <div class="flex flex-wrap gap-2 items-center">
                            <span class="text-gray-400 text-xs">Active filters:</span>

                            @if(request('search'))
                                <span class="bg-indigo-500/20 text-indigo-300 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                                    Search: "{{ Str::limit(request('search'), 20) }}"
                                    <a href="{{ url('/posts?' . http_build_query(array_filter(request()->except('search')))) }}" 
                                       class="hover:text-white ml-1">×</a>
                                </span>
                            @endif

                            @if(request('category'))
                                @php
                                    $selectedCategory = $categories->firstWhere('id', request('category'));
                                @endphp
                                <span class="bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                                    Category: {{ $selectedCategory->activity ?? 'Unknown' }}
                                    <a href="{{ url('/posts?' . http_build_query(array_filter(request()->except('category')))) }}" 
                                       class="hover:text-white ml-1">×</a>
                                </span>
                            @endif

                            @if(request('author'))
                                <span class="bg-green-500/20 text-green-300 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                                    Author: {{ request('author') }}
                                    <a href="{{ url('/posts?' . http_build_query(array_filter(request()->except('author')))) }}" 
                                       class="hover:text-white ml-1">×</a>
                                </span>
                            @endif

                            @if(request('sort') && request('sort') != 'latest')
                                <span class="bg-orange-500/20 text-orange-300 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                                    Sort: {{ ucfirst(request('sort')) }}
                                    <a href="{{ url('/posts?' . http_build_query(array_filter(request()->except('sort')))) }}" 
                                       class="hover:text-white ml-1">×</a>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

            </form>
        </div>
    </div>

    <!-- Results Count -->
    @if($posts->count() > 0)
        <p class="text-gray-400 text-sm mb-6">
            Showing <span class="text-white font-semibold">{{ $posts->count() }}</span>
            {{ Str::plural('post', $posts->count()) }}
        </p>
    @endif

    <!-- POSTS LIST -->
    <section class="bg-white dark:bg-gray-900">
        <div class="py-4 px-4 mx-auto max-w-screen-xl lg:py-8 lg:px-0">

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($posts as $post)
                    <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 hover:shadow-xl transition-shadow">

                        <div class="flex justify-between items-center mb-5 text-gray-500">
                            <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path>
                                </svg>
                                Article
                            </span>
                            <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <a href="{{ route('post.show', $post->id) }}" class="hover:text-indigo-500 transition">
                                {{ Str::limit($post->title, 45)}}
                            </a>
                        </h2>

                        <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                            {{ Str::limit($post->body, 140) }}
                        </p>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <img class="w-7 h-7 rounded-full" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($post->author_name ?? $post->author->name) }}&background=6366f1&color=fff" 
                                     alt="{{ $post->author_name ?? $post->author->name }}">
                                
                                <a href="{{ url('/posts?author=' . urlencode($post->author_name)) }}" 
                                   class="font-medium w-3/4 dark:text-white hover:text-indigo-500 transition">
                                    {{ $post->author_name ?? $post->author->name }}
                                </a>
                            </div>

                            <a href="{{ route('post.show', $post->id) }}" 
                               class="inline-flex items-center font-medium text-indigo-600 dark:text-indigo-500 hover:text-indigo-700 transition">
                                Read more
                                <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ url('/categories/' . $post->category->slug) }}" 
                               class="inline-flex items-center text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-indigo-500 transition">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                                {{ $post->category->activity }}
                            </a>
                        </div>

                    </article>
                @empty

                    <div class="col-span-full flex justify-center py-12">
                        <div class="rounded-lg p-8 text-center max-w-md w-full">
                            <h3 class="text-xl font-medium text-white mb-2">No posts found</h3>

                            <p class="text-gray-400 mb-4">
                                @if(request('search'))
                                    Try adjusting your search keyword.
                                @else
                                    No blog posts available.
                                @endif
                            </p>

                            @if(request('search'))
                                <a href="{{ url('/posts') }}" 
                                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                                    View All Posts
                                </a>
                            @endif
                        </div>
                    </div>

                @endforelse

            </div>
        </div>
    </section>

    <script>
        // Toggle Advanced Filters
        const toggleBtn = document.getElementById('toggleAdvanced');
        const advancedFilters = document.getElementById('advancedFilters');
        const advancedIcon = document.getElementById('advancedIcon');

        toggleBtn.addEventListener('click', () => {
            advancedFilters.classList.toggle('hidden');
            advancedIcon.classList.toggle('rotate-180');
        });

        // Auto-open if any advanced filter is active
        @if(request('category') || request('author') || (request('sort') && request('sort') != 'latest'))
            advancedFilters.classList.remove('hidden');
            advancedIcon.classList.add('rotate-180');
        @endif
    </script>

</x-layout>