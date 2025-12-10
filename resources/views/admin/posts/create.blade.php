<x-layout>
    <x-slot:title>Create New Post</x-slot:title>

    <div class="max-w-4xl mx-auto py-4 sm:py-6 px-4 sm:px-0">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.posts.index') }}" 
               class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-xl sm:text-2xl font-bold text-white">Create New Post</h2>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4 text-sm">
                <p class="font-semibold mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-4 sm:p-6 space-y-4 sm:space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-white mb-2 font-medium text-sm sm:text-base">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full bg-gray-700 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter post title">
            </div>

            <!-- Featured Image -->
            <div>
                <label class="block text-white mb-2 font-medium text-sm sm:text-base">Featured Image</label>
                <input type="file" name="image" accept="image/*" id="imageInput"
                    class="w-full bg-gray-700 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer">
                <p class="text-gray-400 text-xs mt-2">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF (Optional)</p>
                
                <!-- Preview Container -->
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-gray-400 text-sm mb-2">Preview:</p>
                    <img src="" alt="Preview" class="w-full sm:max-w-md h-48 object-cover rounded-lg">
                </div>
            </div>

            <!-- Author Name -->
            <div>
                <label class="block text-white mb-2 font-medium text-sm sm:text-base">
                    Author Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="author_name" value="{{ old('author_name') }}" required
                    class="w-full bg-gray-700 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="e.g., John Doe">
                <p class="text-gray-400 text-xs mt-1">Enter the author's name</p>
            </div>

            <!-- Category -->
            <div>
                <label class="block text-white mb-2 font-medium text-sm sm:text-base">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="cate_id" required
                    class="w-full bg-gray-700 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('cate_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->activity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-white mb-2 font-medium text-sm sm:text-base">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea name="body" rows="12" required
                    class="w-full bg-gray-700 text-white rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-y"
                    placeholder="Write your post content here...">{{ old('body') }}</textarea>
                <p class="text-gray-400 text-xs mt-1">Minimum 50 characters recommended</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="submit"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-medium text-sm sm:text-base transition order-1 sm:order-1">
                    Create Post
                </button>
                <a href="{{ route('admin.posts.index') }}"
                    class="w-full sm:w-auto text-center bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium text-sm sm:text-base transition order-2 sm:order-2">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        // Image Preview
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto-save to localStorage (optional)
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input[type="text"], textarea, select');
        
        // Load saved data
        inputs.forEach(input => {
            const savedValue = localStorage.getItem(`post_create_${input.name}`);
            if (savedValue && !input.value) {
                input.value = savedValue;
            }
        });

        // Save data on input
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                localStorage.setItem(`post_create_${this.name}`, this.value);
            });
        });

        // Clear localStorage on successful submit
        form.addEventListener('submit', function() {
            inputs.forEach(input => {
                localStorage.removeItem(`post_create_${input.name}`);
            });
        });
    </script>
</x-layout>