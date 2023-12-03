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
                    id="searchInput">
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">Rechercher</button>
                </form>
            </div>
        </div>

        <div class="max-w-3xl mx-auto">
            @foreach ($posts as $post)
                <div class="mb-8">
                    <a href="{{ route('posts.show', $post) }}" class="flex bg-white rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition">
                        <div>
                            <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto">
                        </div>
                        <div class="flex flex-col ml-4">
                            <h2 class="font-bold text-gray-800">{{ $post->title }}</h2>
                            <p class="text-gray-600">{{ Str::limit($post->body, 120) }}</p>
                            <p class="text-xs text-gray-500">{{ $post->published_at->diffForHumans() }}</p>
                            <p class="text-xs text-gray-500">Posté par : {{ $post->user->name }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="pagination mt-8">
            {{ $posts->links() }}
        </div>
    </div>


</x-guest-layout>
