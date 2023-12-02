<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class SearchController extends Controller
{
    public function searchPosts(Request $request)
    {
        $query = $request->input('query');

        // Recherche des posts par le contenu du corps (body)
        $posts = Post::where('body', 'LIKE', "%$query%");

        // Recherche des utilisateurs par nom
        $users = User::where('name', 'LIKE', "%$query%")->get();

        // Obtenez les IDs des posts pour les utilisateurs trouvés
        $userPostIds = $users->flatMap(function ($user) {
            return $user->posts->pluck('id');
        });

        // Combinez les résultats des deux requêtes
        $posts = $posts->orWhereIn('id', $userPostIds)->paginate(10);

        return view('posts.search', compact('posts', 'query'));
    }
}

