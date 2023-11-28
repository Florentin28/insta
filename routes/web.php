<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page d'accueil pour les utilisateurs non authentifiés
Route::get('/', function () {
    return view('welcome');
});

// Page d'accueil avec les posts
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/home', [HomepageController::class, 'index'])->name('homepage');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts/store', [PostController::class, 'store'])->name('posts.store');
Route::get('/search/posts', [SearchController::class, 'searchPosts'])->name('search.posts');



// Routes accessibles uniquement aux utilisateurs authentifiés
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil utilisateur
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::post('/profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Articles
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
});

// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
