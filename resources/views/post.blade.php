<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <main class="pb-16 lg:pt-8 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
        <div class="flex justify-between px-4 mx-auto max-w-screen-l ">
            <article class="mx-auto w-full max-w-6xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <header class="mb-4 lg:mb-6 not-format">
                    <a href="/posts" class="font-medium text-sm text-blue-600 hover:underline ">&laquo; Back to All Posts</a>
                    
                    <address class="flex items-center my-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                            <img class="mr-4 w-16 h-16 rounded-full mb-3" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode($post->author_name) }}&background=6366f1&color=fff" 
                                 alt="{{ $post->author_name }}">
                            <div>
                                <a href="/posts?author={{ urlencode($post->author_name) }}" rel="author" class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $post->author_name }}
                                </a>
                                <p class="text-base text-gray-500 dark:text-gray-400 mb-1">
                                    {{ $post->created_at->format('l, j F Y') }}
                                </p>
                                <div class="flex justify-between items-center mb-5 text-gray-500">
                                    <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path>
                                        </svg>
                                        <a href="/categories/{{ $post->category->slug }}">{{ $post->category->activity }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </address>
                    
                    <h1 class="mb-4 pt-3 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                        {{ $post->title }}
                    </h1>

                    <!-- Featured Image -->
                    @if($post->image)
                        <div class="mb-6">
                            <img src="{{ Storage::url($post->image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-auto rounded-lg shadow-lg">
                        </div>
                    @endif
                </header>
                
                <p class="lead whitespace-pre-line">{{ $post->body }}</p>
            </article>
        </div>
    </main>
</x-layout>