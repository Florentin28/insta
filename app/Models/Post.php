<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Les attributs remplissables du modèle
    protected $fillable = [
        'body', 'published_at', 'img_path', 'user_id', 'caption',
    ];

    // Les attributs qui doivent être traités comme des dates
    protected $casts = ["published_at" => "datetime"];

    // Relation avec le modèle User (Un post appartient à un utilisateur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le modèle Like (Un post peut avoir plusieurs likes)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Vérifie si le post est aimé par l'utilisateur donné
    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    // Nombre total de likes pour le post
    public function likeCount()
    {
        return $this->likes->count();
    }

    // Relation avec le modèle Comment (Un post peut avoir plusieurs commentaires)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Nombre total de commentaires pour le post
    public function commentCount()
    {
        return $this->comments->count();
    }
}
