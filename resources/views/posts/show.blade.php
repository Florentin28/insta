<x-guest-layout>
    <a href="{{ route('homepage') }}" class="bg-red-700 text-white px-4 py-2 rounded-md transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300 inline-block mb-4 ml-2 border-2 border-black">
        Retour à la liste des posts
    </a>

    <div class="max-w-2xl mx-auto">
        <!-- Section pour afficher l'avatar et le nom de l'utilisateur -->
        <div class="flex items-center mb-4">
            <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="Photo de profil de {{ $post->user->name }}" class="w-12 h-12 rounded-full mr-2">
            <span class="font-bold text-lg text-black">{{ $post->user->name }}</span>
        </div>

        <h1 class="font-bold text-2xl mb-4">{{ $post->title }}</h1>
        <div class="mb-4 text-xs text-black">
            <span class="font-bold times-new-roman">{{ $post->published_at->diffForHumans() }}</span><br>
        </div>
        <div class="mb-8">
            <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-md border-2 border-black">
        </div>
        <div class="border border-black p-4 rounded-md text-center">
            <div id="description-short" class="description">
                <!-- Afficher les 100 premiers caractères de la description -->
                {{ Str::limit(strip_tags($post->body), 100) }}
            </div>
            <div id="description-full" class="hidden description">
                <!-- Afficher la description complète -->
                {!! \nl2br($post->body) !!}
            </div>

            <!-- Bouton "Afficher plus/moins" -->
            <button id="show-more-btn" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md border-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                Afficher plus
            </button>
        </div>

        @if(auth()->check() && auth()->user()->id !== $post->user->id)
            <!-- Boutons d'abonnement, voir le profil, Like, et compteur de likes -->
            <div class="flex items-center justify-center mt-4 space-x-4">
                {{-- Bouton pour se désabonner ou s'abonner --}}
                @if(auth()->user()->following->contains($post->user))
                    <form action="{{ route('profile.unfollow', $post->user) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-md border-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                            Se désabonner de {{ $post->user->name }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('profile.follow', $post->user) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-md border-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                            S'abonner à {{ $post->user->name }}
                        </button>
                    </form>
                @endif

                {{-- Bouton pour afficher le profil --}}
                <a href="{{ route('profile.show', $post->user) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md border-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                    Voir le profil
                </a>

                {{-- Bouton pour liker ou unliker le post --}}
                @if(auth()->check())
                    <form action="{{ route('posts.toggleLike', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-md border-2 border-black font-bold transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                            {{ $post->likedBy(auth()->user()) ? 'Unlike' : 'Like' }}
                        </button>
                    </form>
                @endif

                {{-- Afficher le nombre de likes --}}
                <p class="text-green-600 font-bold text-lg">
                    {{ $post->likeCount() }} {{ Str::plural('like', $post->likeCount()) }}
                </p>
            </div>
        @endif

        <!-- Ajout du formulaire pour ajouter un commentaire -->
        <div class="mt-8 border-2 border-black p-4 mb-4 rounded-md text-center">
            <h2 class="font-bold text-lg mb-4">Ajouter un commentaire</h2>
            @auth
                <form action="{{ route('posts.comment', $post) }}" method="POST">
                    @csrf
                    <textarea name="body" rows="3" placeholder="Votre commentaire" class="border rounded-md p-2 w-full focus:outline-none focus:ring focus:border-custom-focus-color transition-colors duration-300"></textarea>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md border-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300">
                        Ajouter un commentaire
                    </button>
                </form>
            @else
                <p>Connectez-vous pour ajouter un commentaire.</p>
            @endauth
        </div>

      <!-- Affichage des commentaires -->
<div class="rounded-md border-2 border-black p-4 mb-4 text-center">
    <h2 class="font-bold text-lg mb-4">Commentaires</h2>
    @forelse ($post->comments as $comment)
        <div class="mb-4 border-2 border-black p-2 rounded-md"> <!-- Ajout de la classe border-2 et p-2 -->
            <p class="font-bold">{{ $comment->user->name }}</p>
            <p>{{ $comment->body }}</p>
            @if(auth()->check() && auth()->user()->id === $comment->user->id)
                <form action="{{ route('comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-md border-2 border-black transition-transform hover:scale-105 focus:outline-none focus:ring focus:border-custom-focus-color duration-300 mt-2">
                        Supprimer
                    </button>
                </form>
            @endif
        </div>
    @empty
        <p>Aucun commentaire pour le moment.</p>
    @endforelse
</div>



    </div>
{{-- J'ai mis du Javascript car j'aime vivre dans le danger --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const descriptionShort = document.getElementById('description-short');
            const descriptionFull = document.getElementById('description-full');
            const showMoreBtn = document.getElementById('show-more-btn');

            showMoreBtn.addEventListener('click', function () {
                descriptionShort.classList.toggle('hidden');
                descriptionFull.classList.toggle('hidden');

                // Modifier le texte du bouton
                const isHidden = descriptionShort.classList.contains('hidden');
                showMoreBtn.textContent = isHidden ? 'Afficher moins' : 'Afficher plus';
            });
        });
    </script>
</x-guest-layout>
