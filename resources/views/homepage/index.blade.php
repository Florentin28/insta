<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">Liste des posts</h1>
    <ul class="grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-8">
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}" class="flex bg-white rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition">
                    <div>
                        <img src="{{ asset('storage/images/' . basename($post->img_path)) }}" alt="{{ $post->title }}" class="w-full h-auto">
                    </div>
                    <div class="flex flex-col ml-4">
                        <h2 class="font-bold text-gray-800">{{ $post->title }}</h2>
                        <p class="text-gray-600">{{ Str::limit($post->body, 120) }}</p>
                        <p class="text-xs text-gray-500">{{ $post->published_at }}</p>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-guest-layout>


<!-- Footer -->
<footer class="bg-gray-800 text-white p-4 text-center mt-8">
    <div class="flex flex-col items-center space-y-2">
        <p>Instagram par Florentin Muraille</p>
        <a href="https://github.com/Florentin28" class="text-gray-500 hover:text-gray-300">
            GitHub
        </a>
    </div>
</footer>

