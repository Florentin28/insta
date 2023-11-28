<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function searchPosts(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::where('body', 'LIKE', "%$query%")
            ->paginate(10);

        return view('posts.search', compact('posts', 'query'));
    }
}
