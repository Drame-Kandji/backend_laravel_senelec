<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Création de compte (inscription)
     */
    public function register(Request $request)
    {
        // dd($request->prenom);
        $validated = $request->validate([
            'prenom' => 'string',
            'nom' => 'string',
            'telephonne' => 'string',
            'numeroCompteur' => 'string',
            'address' => 'string',
            'role' => 'string',
            'agence' => 'string',
            'delegation' => 'string',
            'email' => 'nullable',
            'password' => 'string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Compte créé avec succès',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Connexion utilisateur par email ou numéroCompteur
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string',
            'password' => 'required|string'
        ]);

        // Recherche par email ou numeroCompteur
        $user = User::where('email', $request->identifiant)
                    ->orWhere('numeroCompteur', $request->identifiant)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Mot de passe incorrect'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Déconnexion (suppression des tokens)
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
