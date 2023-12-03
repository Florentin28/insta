<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être attribués de manière massive.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'bio',
    ];

    /**
     * Les attributs qui devraient être cachés lors de la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui devraient être transformés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relation avec le modèle Post (Un utilisateur peut avoir plusieurs posts)
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Relation de suivi avec d'autres utilisateurs
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')
                    ->withTimestamps();
    }

    // Relation des followers de l'utilisateur
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')
                    ->withTimestamps();
    }

    // Nombre total de followers pour l'utilisateur
    public function followersCount()
    {
        return $this->followers()->count();
    }

    // Relation avec le modèle Like (Un utilisateur peut avoir plusieurs likes)
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}
