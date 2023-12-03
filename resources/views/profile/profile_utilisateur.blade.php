<x-guest-layout>
    <h1 class="font-bold text-4xl mb-4 text-center">{{ $user->name }}</h1>

    <!-- Photo de profil -->
    @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}'s profile picture" class="w-32 h-32 mb-4 rounded-full mx-auto">
    @endif

    <!-- Nombre de followers -->
    <div class="mb-4 text-center">
        <p class="text-lg font-bold text-black">{{ $user->followersCount() }}</p>
        <p class="text-sm text-black">Followers</p>
    </div>

    <!-- Afficher les posts de l'utilisateur -->
    <h2 class="font-bold text-lg mb-2 text-center">Posts de {{ $user->name }}</h2>
    <ul class="flex justify-center flex-wrap">
        @forelse($user->posts as $post)
            <li class="mb-4 mx-4">
                <a href="{{ route('posts.show', $post) }}" class="flex bg-gradient-to-r from-pink-500 via-red-500 to-orange-500 border-black border-4 rounded-md shadow-md p-5 custom-post-width hover:shadow-lg hover:scale-105 transition">
                    <div>
                        <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-24 h-24 rounded-md">
                    </div>
                    <div class="flex flex-col ml-4">
                        <h3 class="font-bold text-white">{{ $post->title }}</h3>
                        <p class="text-gray-300">{{ Str::limit($post->body, 100) }}</p>
                        <p class="text-xs text-gray-300">{{ $post->published_at }}</p>
                    </div>
                </a>
            </li>
        @empty
            <p>Aucun post trouvé pour {{ $user->name }}.</p>
        @endforelse
    </ul>

    <!-- Ajoutez d'autres détails du profil que vous souhaitez afficher -->

    <a href="{{ route('homepage') }}" class="block mt-8 bg-blue-500 text-white px-4 py-2 rounded-md transition-transform hover:scale-100 focus:outline-none focus:ring focus:border-custom-focus-color duration-300 text-center mx-auto">
        Retour à la liste des posts
    </a>
</x-guest-layout>
