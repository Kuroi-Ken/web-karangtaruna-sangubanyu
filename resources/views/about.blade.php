<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @if($about)
        <div class="py-12">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                    {{ $about->title }}
                </h1>
            </div>

            <!-- Image Section (if exists) -->
            @if($about->image)
                <div class="mb-12">
                    <img src="{{ Storage::url($about->image) }}" 
                         alt="{{ $about->title }}"
                         class="w-full max-w-4xl mx-auto h-64 sm:h-96 object-cover rounded-2xl shadow-2xl">
                </div>
            @endif

            <!-- Description Section -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-gray-800 rounded-2xl p-6 sm:p-8 border border-gray-700">
                    <p class="text-gray-300 text-lg leading-relaxed whitespace-pre-line">
                        {{ $about->description }}
                    </p>
                </div>
            </div>

            <!-- Vision & Mission Section -->
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                <!-- Vision -->
                <div class="bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-2xl p-6 sm:p-8 border border-indigo-500/50">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin