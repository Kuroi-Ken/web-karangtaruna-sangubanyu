<x-layout>
    <x-slot:title>Edit About Page</x-slot:title>

    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Edit About Page</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.about.update', $about) }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-6 space-y-6">
            @csrf
            @method('PUT')

            @if($about->image)
                <div>
                    <label class="block text-white mb-2 font-medium">Current Image</label>
                    <img src="{{ Storage::url($about->image) }}" 
                         alt="{{ $about->title }}"
                         class="w-full max-w-md h-64 object-cover rounded">
                </div>
            @endif

            <!-- Title -->
            <div>
                <label class="block text-white mb-2 font-medium">Title *</label>
                <input type="text" name="title" value="{{ old('title', $about->title) }}" required
                    placeholder="e.g., Tentang Karang Taruna"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-white mb-2 font-medium">Description *</label>
                <textarea name="description" rows="6" required
                    placeholder="Deskripsi umum tentang Karang Taruna..."
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $about->description) }}</textarea>
            </div>

            <!-- Vision -->
            <div>
                <label class="block text-white mb-2 font-medium">Vision (Visi) *</label>
                <textarea name="vision" rows="4" required
                    placeholder="Visi organisasi..."
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('vision', $about->vision) }}</textarea>
            </div>

            <!-- Mission -->
            <div>
                <label class="block text-white mb-2 font-medium">Mission (Misi) *</label>
                <div id="mission-container" class="space-y-3">
                    @php
                        $missions = old('mission', $about->mission ?? []);
                    @endphp
                    @foreach($missions as $index => $mission)
                        <div class="mission-item flex gap-2">
                            <input type="text" name="mission[]" value="{{ $mission }}" required
                                placeholder="Poin misi {{ $index + 1 }}"
                                class="flex-1 bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @if($index > 0)
                                <button type="button" onclick="this.parentElement.remove()"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">
                                    Remove
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-mission"
                    class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                    + Add More Mission Point
                </button>
            </div>

            <!-- Image -->
            <div>
                <label class="block text-white mb-2 font-medium">Change Image (optional)</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Leave empty to keep current image</p>
            </div>

            <!-- Active Status -->
            <div class="p-4 bg-indigo-500/10 border border-indigo-500 rounded">
                <label class="flex items-start text-white">
                    <input type="checkbox" name="is_active" value="1" {{ $about->is_active ? 'checked' : '' }}
                        class="mr-2 mt-1 rounded bg-gray-700 border-gray-600">
                    <div>
                        <span class="font-semibold">Set as Active Page</span>
                        <p class="text-sm text-gray-300 mt-1">This will be displayed on the public about page. Only one page can be active at a time.</p>
                    </div>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                    Update About Page
                </button>
                <a href="{{ route('admin.about.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        // Add mission point
        document.getElementById('add-mission').addEventListener('click', function() {
            const container = document.getElementById('mission-container');
            const count = container.children.length + 1;
            
            const div = document.createElement('div');
            div.className = 'mission-item flex gap-2';
            div.innerHTML = `
                <input type="text" name="mission[]" required
                    placeholder="Poin misi ${count}"
                    class="flex-1 bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="button" onclick="this.parentElement.remove()"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded">
                    Remove
                </button>
            `;
            
            container.appendChild(div);
        });
    </script>
</x-layout>