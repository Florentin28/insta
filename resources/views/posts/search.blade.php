<x-guest-layout>
    <a href="{{ route('homepage') }}" class="bg-red-700 text-white px-4 py-2 rounded-md transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300 inline-block mb-4 ml-2 border-2 border-black">
        Retour à la liste des posts
    </a>
    <div class="overflow-x-hidden bg-gradient-to-r from-pink-500 via-red-500 to-orange-500 min-h-screen flex flex-col justify-center">

        <p class="text-black">Résultats pour la recherche : "{{ $query }}"</p>

        <div class="max-w-3xl mx-auto">
            @forelse($posts as $post)
                <div class="mb-8">
                    <a href="{{ route('posts.show', $post) }}" class="flex bg-gradient-to-r from-pink-500 via-red-500 to-orange-500 border-black border-4 rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition">
                        <div class="w-1/3">
                            <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-md">
                        </div>
                        <div class="flex flex-col ml-4 w-2/3 text-white">
                            <!-- Affichage de la photo de profil de l'utilisateur avec le pseudo -->
                            <div class="flex items-center mb-2">
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="Photo de profil de {{ $post->user->name }}" class="w-12 h-12 rounded-full mr-2">
                                <span class="font-bold text-lg">{{ $post->user->name }}</span>
                            </div>
                            <h2 class="font-bold text-2xl">{{ $post->title }}</h2>
                            <p class="text-gray-300">{{ Str::limit($post->body, 120) }}</p>
                            <p class="text-sm">{{ $post->published_at->diffForHumans() }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-black">Aucun résultat trouvé.</p>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $posts->links() }}
        </div>
    </div>
</x-guest-layout>
