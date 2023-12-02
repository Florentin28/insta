<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;


class HomepageController extends Controller
{
    public function index()
{
    // Obtenir tous les posts paginés
    $allPosts = Post::latest()->get();

    // Obtenir les utilisateurs suivis
    $followedUsers = Auth::user()->following;

    // Obtenir les posts des utilisateurs suivis
    $followedPosts = Post::whereIn('user_id', $followedUsers->pluck('id'))
        ->latest()
        ->get();

    // Obtenir les posts les plus likés
    $mostLikedPosts = Post::withCount('likes')
        ->orderByDesc('likes_count')
        ->get();

    // Obtenir les autres posts
    $otherPosts = $allPosts->diff($followedPosts)->diff($mostLikedPosts)->values();

    // Fusionner les résultats
    $posts = $followedPosts->merge($mostLikedPosts)->merge($otherPosts);

    // Paginer les résultats avec LengthAwarePaginator
    $perPage = 10; // Nombre d'articles par page
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentPageItems = $posts->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $posts = new LengthAwarePaginator($currentPageItems, count($posts), $perPage);

    return view('homepage.index', compact('posts'));
}
}
