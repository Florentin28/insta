<x-guest-layout>
    <a href="{{ route('homepage') }}" class="text-blue-500 hover:underline">Retour à la liste des posts</a>

    <h1 class="font-bold text-xl mb-4">{{ $post->title }}</h1>
    <div class="mb-4 text-xs text-gray-500">
        {{ $post->published_at }}
    </div>
    <div>
        <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto mb-4">
        {!! \nl2br($post->body) !!}
    </div>
</x-guest-layout>
