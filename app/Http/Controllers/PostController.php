<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(12);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
{
    // Validez les données du formulaire
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'caption' => 'nullable|string|max:255',
        'body' => 'required|string', // Ajoutez cette ligne pour valider le champ body
    ]);

    // Enregistrez la publication dans la base de données
    $post = new Post();
    $post->user_id = Auth::id();
    $post->caption = $request->input('caption');
    $post->body = $request->input('body'); // Ajoutez cette ligne pour enregistrer le champ body

    // Enregistrez l'image dans le système de fichiers
    $photoPath = $request->file('photo')->store('post-photos', 'public');
    $post->photo = $photoPath;

    $post->save();

    // Redirigez l'utilisateur vers la page de la publication ou une autre page de votre choix
    return redirect()->route('posts.show', $post->id)->with('status', 'Post created successfully');
}

}
