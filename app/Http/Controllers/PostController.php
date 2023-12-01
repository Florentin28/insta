<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Like; // Assurez-vous d'inclure le modèle Like

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
    public function like(Post $post)
    {
        // Assurez-vous que l'utilisateur est authentifié avant de permettre le like
        if (auth()->check()) {
            // Vérifiez si l'utilisateur n'a pas déjà liké le post
            if (!$post->likes()->where('user_id', auth()->user()->id)->exists()) {
                // Créez un like pour ce post par cet utilisateur
                $like = new Like();
                $like->user_id = auth()->user()->id;

                $post->likes()->save($like);
            }
        }

        // Redirigez l'utilisateur vers la page du post
        return redirect()->route('posts.show', $post);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
{
    // Validez les données du formulaire
    $request->validate([
        'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'caption' => 'nullable|string|max:255',
        'body' => 'required|string',
    ]);



    // Enregistrez la publication dans la base de données
    $post = new Post();
    $post->user_id = Auth::id();
    $post->caption = $request->input('caption');
    $post->body = $request->input('body');
    $post->published_at = Carbon::now();

    // Enregistrez l'image dans le système de fichiers et enregistrez le chemin dans la base de données
    $imgPath = $request->file('img_path')->store('images', 'public');
    $post->img_path = $imgPath;

    $post->save();

    // Redirigez l'utilisateur vers la page de la publication ou une autre page de votre choix
    return redirect()->route('posts.show', $post->id)->with('status', 'Post created successfully');
}




}
