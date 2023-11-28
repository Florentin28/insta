<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">{{ $user->name }}</h1>
    <!-- Ajoutez d'autres détails du profil que vous souhaitez afficher -->
    <a href="{{ route('homepage') }}" class="text-blue-500 hover:underline">Retour à la liste des posts</a>
</x-guest-layout>
