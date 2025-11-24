<x-layout >
    <x-slot:title>{{ $title }}</x-slot:title>

@foreach ($posts as $post)
    <article class="text-white py-8 max-w-screen-md border-white">
        <a href="/posts/{{ $post ['id'] }}" class="hover:underline">
            <h1 class="mb-1 text-3xl tracking-tight font-bold">{{ $post ['title'] }}</h1>
        </a>
        <div class="text-base text-gray-500">
            <a href="/authors/{{ $post->author->id }}" class="hover:underline">{{ $post->author->name}} Di {{ $post->categor->id }} | {{$post->created_at->diffForHumans()}};</a> | 
        </div>
        <p class="my-4 font-light">
            {{ Str::limit($post ['body'], 150) }}
        </p>
        <a href="/posts/{{ $post ['id'] }}" class="font-medium text-blue-500 hover:underline">Read More &raquo;</a>
    </article>
@endforeach

</x-layout>
