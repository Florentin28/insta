<?php


namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{

    public function toggleLike(Post $post)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($post->likedBy($user)) {
                $user->likes()->where('post_id', $post->id)->delete();
            } else {
                $like = new Like();
                $like->user_id = $user->id;
                $post->likes()->save($like);
            }
        }

        return redirect()->route('posts.show', $post);
    }

    public function destroyComment(Post $post, Comment $comment)
    {
        // Assurez-vous que l'utilisateur est autorisé à supprimer le commentaire
        if (auth()->user()->id !== $comment->user_id) {
            // Redirigez l'utilisateur avec un message d'erreur
            return redirect()->route('posts.show', $post->id)->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }

        // Supprimez le commentaire
        $comment->delete();

        // Redirigez l'utilisateur vers la page du post
        return redirect()->route('posts.show', $post)->with('status', 'Commentaire supprimé avec succès.');
    }



    public function show($id)
    {
        $post = Post::with('comments.user')->findOrFail($id);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function like(Post $post)
    {
        // Assurez-vous que l'utilisateur est authentifié avant de permettre le like
        if (auth()->check()) {
            $user = auth()->user();

            // Vérifiez si l'utilisateur a déjà liké le post
            if ($post->likedBy($user)) {
                // Retirez le like
                $user->likes()->where('post_id', $post->id)->delete();
            } else {
                // Ajoutez le like
                $like = new Like();
                $like->user_id = $user->id;
                $post->likes()->save($like);
            }
        }

        // Redirigez l'utilisateur vers la page du post
        return redirect()->route('posts.show', $post);
    }

    public function comment(Request $request, Post $post)
    {
        // Validation du formulaire
        $request->validate([
            'body' => 'required|string',
        ]);

        // Vérifiez si l'utilisateur est authentifié
        if (Auth::check()) {
            // Création du commentaire associé au post
            Comment::create([
                'body' => $request->input('body'),
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
            ]);
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
