<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomepageController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(12);

        return view('homepage.index', [
            'posts' => $posts,
        ]);
    }
}
