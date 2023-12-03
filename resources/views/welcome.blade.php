<x-guest-layout>
    <div class="flex flex-col items-center justify-center h-full overflow-hidden">
        <h1 class="font-bold text-3xl mb-8 mt-24">Bienvenue sur Instagram</h1>

        <div class="flex flex-col items-center space-y-4">
            <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md border border-width-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                Créer un compte
            </a>
            <a href="{{ route('login') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md border border-width-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                Se connecter
            </a>
        </div>
    </div>
</x-guest-layout>
