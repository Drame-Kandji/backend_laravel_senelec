<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class StatistiqueController extends Controller
{
    /**
     * Statistiques générales sur les réclamations et les utilisateurs
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'total_reclamations' => Reclamation::count(),

            'reclamations_par_statut' => [
                'en attente' => Reclamation::where('statut', 'en attente')->count(),
                'traitee'    => Reclamation::where('statut', 'traitee')->count(),
            ],

            'reclamations_par_categorie' => Category::withCount('reclamations')->get()->map(function ($cat) {
                return [
                    'categorie' => $cat->nom,
                    'nombre'    => $cat->reclamations_count
                ];
            }),

            'users_par_role' => [
                'admin'      => User::where('role', 'admin')->count(),
                'directeur'  => User::where('role', 'directeur')->count(),
                'client'     => User::where('role', 'client')->count(),
                'encadreur'  => User::where('role', 'encadreur')->count(),
                'technicien' => User::where('role', 'technicien')->count(),
            ]
        ]);
    }

    /**
     * Réclamations pour un utilisateur donné
     */
    public function reclamationsParUtilisateur($id): JsonResponse
    {
        $user = User::with('reclamations.category')->findOrFail($id);

        $reclamations = $user->reclamations;

        return response()->json([
            'user' => $user,
            'total_reclamations' => $reclamations->count(),
            'reclamations' => $reclamations,
            'reclamations_en_attente' => $reclamations->where('statut', 'en attente')->values(),
            'reclamations_traitees' => $reclamations->where('statut', 'traitée')->values(),
        ]);
    }

    public function statistiquesParRole(): JsonResponse
    {
        $roles = ['client', 'technicien', 'encadreur', 'admin', 'directeur'];

        $statistiques = [];

        foreach ($roles as $role) {
            $statistiques[$role] = User::where('role', $role)->count();
        }

        return response()->json([
            'statistiques_utilisateurs' => $statistiques
        ]);
    }

}
