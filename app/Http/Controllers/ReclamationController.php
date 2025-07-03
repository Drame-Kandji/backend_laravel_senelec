<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
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
}
