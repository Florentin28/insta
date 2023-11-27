<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Mettez à jour les informations du profil
        $userData = [
            'name' => $request->input('name'),
            'bio' => $request->filled('bio') ? $request->input('bio') : null,
        ];

        // Ajoutez l'avatar uniquement si un fichier a été téléchargé
        if ($request->hasFile('avatar')) {
            // Stockez le fichier dans le système de fichiers
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            // Mettez à jour le chemin de l'avatar dans les données utilisateur
            $userData['avatar'] = $avatarPath;
        } elseif ($request->filled('remove_avatar')) {
            // Supprimez l'avatar si la case à cocher "remove_avatar" est cochée
            $userData['avatar'] = null;
        }

        // Mettez à jour les données de l'utilisateur
        $user->update($userData);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }




    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
