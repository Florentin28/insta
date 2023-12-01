<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">{{ $user->name }}</h1>

    <!-- Photo de profil -->
    @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}'s profile picture" class="w-full h-auto mb-4 rounded-full">
    @endif

    <!-- Nombre de followers -->
    <p class="mb-4 text-sm text-gray-500">Followers: {{ $user->followersCount() }}</p>

    <!-- Afficher les posts de l'utilisateur -->
    <h2 class="font-bold text-lg mb-2">Posts de {{ $user->name }}</h2>
    <ul>
        @forelse($user->posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}" class="flex bg-white rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition">
                    <div>
                        <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto">
                    </div>
                    <div class="flex flex-col ml-4">
                        <h3 class="font-bold text-gray-800">{{ $post->title }}</h3>
                        <p class="text-gray-600">{{ Str::limit($post->body, 120) }}</p>
                        <p class="text-xs text-gray-500">{{ $post->published_at }}</p>
                    </div>
                </a>
            </li>
        @empty
            <p>Aucun post trouvé pour {{ $user->name }}.</p>
        @endforelse
    </ul>

    <!-- Ajoutez d'autres détails du profil que vous souhaitez afficher -->

    <a href="{{ route('homepage') }}" class="text-blue-500 hover:underline">Retour à la liste des posts</a>

</x-guest-layout>
