<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">Bienvenue sur Instagram</h1>

    <div class="flex justify-center space-x-4">
        <a href="{{ route('register') }}" class="hover:text-gray-500">Créer un compte</a>
        <a href="{{ route('login') }}" class="hover:text-gray-500">Se connecter</a>
    </div>


</x-guest-layout>
