<!-- resources/views/home.blade.php -->
<x-layout>
    <x-slot:title>Selamat Datang di Website Karang Taruna</x-slot:title>

    <div class="py-6">
        {{-- <h2 class="text-white text-2xl font-bold mb-6">Welcome to Our Website</h2> --}}

        @if ($images->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($images as $image)
                    <div class="bg-gray-800 rounded-lg overflow-hidden hover:shadow-xl transition">
                        <img src="{{ Storage::url($image->path) }}" alt="{{ $image->title }}"
                            class="w-full h-64 object-cover">
                        <div class="p-4">
                            <h3 class="text-white font-semibold text-lg mb-2">{{ $image->title }}</h3>
                            @if ($image->description)
                                <p class="text-gray-400 text-sm">{{ $image->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-400 py-12">
                <p>No images to display yet.</p>
            </div>
        @endif
    </div>
</x-layout>