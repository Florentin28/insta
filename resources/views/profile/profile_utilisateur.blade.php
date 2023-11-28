<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">{{ $user->name }}</h1>

    <!-- Photo de profil -->
    @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}'s profile picture" class="w-full h-auto mb-4 rounded-full">
    @endif

    <!-- Nombre de followers -->
    <p class="mb-4 text-sm text-gray-500">Followers: {{ $user->followersCount() }}</p>

    <!-- Ajoutez d'autres détails du profil que vous souhaitez afficher -->

    <a href="{{ route('homepage') }}" class="text-blue-500 hover:underline">Retour à la liste des posts</a>
</x-guest-layout>
