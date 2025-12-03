<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <article class="text-white py-8 max-w-screen-md">
        <h1 class="mb-1 text-3xl tracking-tight font-bold">{{ $post['title'] }}</h1>
        <div class="text-base text-gray-500">
            <a href="/authors/{{ $post->author->username }}" class="hover:underline">{{ $post->author->name }}</a>
            Di
            <a href="/categories/{{ $post->category->slug }}" class="hover:underline">
                {{ $post->category->activity }}
            </a>
            | {{ $post->created_at->format('l, j F Y') }}
        </div>
        <p class="my-4 font-light">
            {{ $post['body'] }}
        </p>
        <a href="/posts" class="font-medium text-blue-500 hover:underline">&laquo; Kembali</a>
    </article>
</x-layout>