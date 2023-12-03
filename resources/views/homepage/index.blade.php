<x-guest-layout>
    <div class="overflow-x-hidden bg-gradient-to-r from-pink-500 via-red-500 to-orange-500 min-h-screen flex flex-col justify-center">
        <div class="flex justify-center w-screen mb-4">
            <div class="flex items-center justify-center mt-4">
                <!-- Barre de recherche -->
                <form action="{{ route('search.posts') }}" method="GET" class="ml-auto mt-4 relative">
                    @csrf
                    <input type="text" name="query" placeholder="Rechercher des posts..." class="border rounded-md p-2 w-80
                        focus:outline-none focus:ring focus:border-custom-focus-color transition-colors duration-300
                        hover:border-opacity-50"
                        id="searchInput"
                    >
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md border-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            <!-- Boucle pour afficher chaque post -->
            @foreach ($posts as $post)
                <div class="mb-8">
                    <!-- Card du post avec lien vers la page détaillée -->
                    <a href="{{ route('posts.show', $post) }}" class="flex bg-gradient-to-r from-pink-500 via-red-500 to-orange-500 border-black border-4 rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition">
                        <div class="w-1/3">
                            <!-- Affichage de l'image du post -->
                            <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-md">
                        </div>
                        <div class="flex flex-col ml-4 w-2/3">
                            <!-- Affichage de la photo de profil de l'utilisateur avec le pseudo -->
                            <div class="flex items-center mb-2">
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="Photo de profil de {{ $post->user->name }}" class="w-12 h-12 rounded-full mr-2">
                                <span class="font-bold text-lg text-white">{{ $post->user->name }}</span>
                            </div>
                            <!-- Titre, corps et date de publication du post -->
                            <h2 class="font-bold text-2xl text-white">{{ $post->title }}</h2>
                            <p class="text-gray-300">{{ Str::limit($post->body, 120) }}</p>
                            <p class="text-sm text-gray-300">
                                <span class="font-bold times-new-roman">{{ $post->published_at->diffForHumans() }}</span><br>
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination pour naviguer entre les pages de posts -->
        <div class="pagination mt-8 mb-8 flex justify-center">
            {{ $posts->links() }}
        </div>
    </div>
</x-guest-layout>
