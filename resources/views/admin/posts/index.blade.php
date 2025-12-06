<x-layout>
    <x-slot:title>Manage Posts</x-slot:title>

    <div class="py-6">
        <x-admin-menu />
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Blog Posts Management</h2>
            <a href="{{ route('admin.posts.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Create New Post
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filter Form -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="flex gap-4 flex-wrap">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search posts by title, content, author, or category..." 
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="min-w-[150px]">
                    <select name="category" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->activity }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Search
                </button>
                @if(request('search') || request('category'))
                    <a href="{{ route('admin.posts.index') }}" 
                       class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-gray-800 rounded-lg overflow-hidden">
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
                                {{ $post->author->name }}
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

        @if($posts->isNotEmpty())
            <div class="mt-4 text-gray-400 text-sm">
                Showing {{ $posts->count() }} post(s)
            </div>
        @endif
    </div>
</x-layout>