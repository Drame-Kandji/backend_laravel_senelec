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
                'en_attente' => Reclamation::where('statut', 'en attente')->count(),
                'traitee'    => Reclamation::where('statut', 'traitée')->count(),
                'rejetee'    => Reclamation::where('statut', 'rejetée')->count(),
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

}
