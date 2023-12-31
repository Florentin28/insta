<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Register web routes for the application. These routes are loaded by
| the RouteServiceProvider and assigned to the "web" middleware group.
| Make something great!
|
*/

// Page d'accueil pour les utilisateurs non authentifiés
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Routes accessibles uniquement aux utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Création d'un nouveau post
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::post('/profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Articles
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

    // Page d'accueil avec les posts
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/toggle-like', [PostController::class, 'toggleLike'])->name('posts.toggleLike');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    Route::delete('/posts/{post}/comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy');

    // Profil utilisateur
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Page d'accueil
    Route::get('/', [HomepageController::class, 'index'])->name('homepage');
    Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');

    // Recherche
    Route::get('/search/posts', [SearchController::class, 'searchPosts'])->name('search.posts');
    Route::get('/search/users', [SearchController::class, 'searchUsers'])->name('search.users');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
});

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Include authentication routes
require __DIR__.'/auth.php';
