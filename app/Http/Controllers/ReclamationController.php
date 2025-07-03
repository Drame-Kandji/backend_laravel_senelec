<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReclamationController extends Controller
{
    public function index()
    {
        return response()->json(
            Auth::user()->reclamations()->with('category')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'description' => 'string',
            'localisation' => 'string',
            'type' => 'string',
        ]);

        $data['user_id'] = Auth::id();
        $data['statut'] = 'en attente';

        $reclamation = Reclamation::create($data);

        return response()->json([
            'message' => 'Réclamation envoyée avec succès',
            'reclamation' => $reclamation->load('category')
        ], 201);
    }

    public function show($id)
    {
        $reclamation = Reclamation::with('category')->findOrFail($id);

        if ($reclamation->user_id !== Auth::id()) {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        return response()->json($reclamation);
    }

    public function assignTechnicien(Request $request, $reclamation_id)
{
    $request->validate([
        'technicien_id' => 'required|exists:users,id',
    ]);

    // Vérifier que l'utilisateur est bien un technicien
    $technicien = User::where('id', $request->technicien_id)
                      ->where('role', 'technicien')
                      ->first();

    if (!$technicien) {
        return response()->json(['message' => 'Le technicien n\'existe pas ou n\'a pas le rôle requis'], 404);
    }

    $reclamation = Reclamation::findOrFail($reclamation_id);
    $reclamation->technicien_id = $technicien->id;
    $reclamation->save();

    return response()->json([
        'message' => 'Réclamation assignée au technicien avec succès',
        'reclamation' => $reclamation
    ]);
}


    public function cloturerReclamation(Request $request, $id)
    {
        $reclamation = Reclamation::findOrFail($id);
        $user= Auth::user();
        // Vérifier si l'utilisateur connecté est bien le technicien assigné
        if (!$user || $user->role !== 'technicien' ||$user->role !== 'encadreur') {
            return response()->json(['message' => 'Accès refusé. Vous n’êtes pas le technicien assigné.'], 403);
        }

        if ($reclamation->statut === 'traitee') {
            return response()->json(['message' => 'Réclamation déjà traitée.'], 400);
        }

        $reclamation->statut = 'traite';
        $reclamation->save();

        return response()->json([
            'message' => 'Réclamation clôturée avec succès.',
            'reclamation' => $reclamation
        ]);
    }

    public function reclamationsParClient($id)
    {
        $client = User::where('role', 'client')->with('reclamations.category')->findOrFail($id);

        return response()->json([
            'client' => $client->prenom . ' ' . $client->nom,
            'total' => $client->reclamations->count(),
            'reclamations' => $client->reclamations
        ]);
}

}
