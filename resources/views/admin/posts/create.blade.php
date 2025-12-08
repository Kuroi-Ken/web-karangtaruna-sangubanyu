<x-layout>
    <x-slot:title>Create New Post</x-slot:title>

    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Create New Post</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.posts.store') }}" method="POST"
            class="bg-gray-800 rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter post title">
            </div>

            <!-- Input Author sebagai String -->
            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Author Name *</label>
                <input type="text" name="author_name" value="{{ old('author_name') }}" required
                    class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter author name (e.g., John Doe)">
                <p class="text-gray-400 text-xs mt-1">Masukkan nama penulis artikel</p>
            </div>

            <div class="mb-4">
                <label class="block text-white mb-2 font-medium">Category *</label>
                <select name="cate_id" required
                    class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('cate_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->activity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-white mb-2 font-medium">Content *</label>
                <textarea name="body" rows="15" required
                    class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Write your post content here...">{{ old('body') }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium">
                    Create Post
                </button>
                <a href="{{ route('admin.posts.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-layout>