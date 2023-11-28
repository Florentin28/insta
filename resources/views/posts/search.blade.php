<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">Résultats de la recherche</h1>

    <p>Résultats pour la recherche : "{{ $query }}"</p>

    <ul>
        @forelse($posts as $post)
        <li>
            <a href="{{ route('posts.show', $post) }}" class="flex bg-white rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition">
                <div>
                    <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto">
                </div>
                <div class="flex flex-col ml-4">
                    <h2 class="font-bold text-gray-800">{{ $post->title }}</h2>
                    <p class="text-gray-600">{{ Str::limit($post->body, 120) }}</p>
                    <p class="text-xs text-gray-500">{{ $post->published_at }}</p>
                </div>
            </a>
        </li>
        @empty
            <p>Aucun résultat trouvé.</p>
        @endforelse
    </ul>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-guest-layout>