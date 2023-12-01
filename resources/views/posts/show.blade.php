<x-guest-layout>
    <a href="{{ route('homepage') }}" class="text-blue-500 hover:underline">Retour à la liste des posts</a>

    <h1 class="font-bold text-xl mb-4">{{ $post->title }}</h1>
    <div class="mb-4 text-xs text-gray-500">
        {{ $post->published_at }}
    </div>
    <div>
        <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto mb-4">
        {!! \nl2br($post->body) !!}
    </div>

    @if(auth()->check() && auth()->user()->id !== $post->user->id)
        <div>
            {{-- Bouton pour suivre le profil --}}
            @if(auth()->user()->following->contains($post->user))
                <form action="{{ route('profile.unfollow', $post->user) }}" method="POST">
                    @csrf
                    <button type="submit">Se désabonner de {{ $post->user->name }}</button>
                </form>
            @else
                <form action="{{ route('profile.follow', $post->user) }}" method="POST">
                    @csrf
                    <button type="submit">Suivre {{ $post->user->name }}</button>
                </form>
            @endif
        </div>

        <div>
{{-- Bouton pour afficher le profil --}}
<a href="{{ route('profile.show', $post->user) }}" class="text-blue-500 hover:underline">Voir le profil</a>
        </div>
    @endif

    <!-- Ajoutez ces lignes où vous souhaitez afficher les boutons de like et le nombre de likes -->
<div>
    {{-- Bouton pour liker le post --}}
    @if(auth()->check())
        <form action="{{ route('posts.like', $post) }}" method="POST">
            @csrf
            <button type="submit">Like</button>
        </form>
    @endif
</div>

<div>
    {{-- Afficher le nombre de likes --}}
    <p>{{ $post->likeCount() }} {{ Str::plural('like', $post->likeCount()) }}</p>
</div>

</x-guest-layout>
