<?php

namespace Database\Seeders;

use App\Models\Reclamation;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ReclamationSeeder extends Seeder
{
    public function run(): void
    {
        // On suppose qu’on a déjà au moins 4 users et 4 catégories
        $users = User::take(4)->get();
        $categories = Category::take(4)->get();

        $types = ['Technique', 'Facturation', 'Compteur', 'Service'];
        $statuts = ['en attente', 'traitée'];

        foreach ($users as $index => $user) {
            Reclamation::create([
                'user_id'      => $user->id,
                'category_id'  => $categories[$index % $categories->count()]->id,
                'description'  => "Réclamation test numéro " . ($index + 1),
                'localisation' => 'Thiès, Quartier ' . chr(65 + $index), // Quartier A, B, C...
                'type'         => $types[$index % count($types)],
                'statut'       => $statuts[$index % count($statuts)],
            ]);
        }
    }
}

