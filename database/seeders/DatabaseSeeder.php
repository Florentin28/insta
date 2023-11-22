<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'), // Remplace 'password' par le mot de passe souhaité
            // ... autres attributs de l'utilisateur
        ]);

        $this->call([
            PostsTableSeeder::class,
        ]);
    }
}
