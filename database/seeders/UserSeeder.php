<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'prenom' => 'Aliou',
                'nom' => 'Dramé',
                'telephonne' => '770000001',
                'numeroCompteur' => 'COMP1001',
                'address' => 'Thiès',
                'role' => 'technicien',
                'agence' => 'Thiès Nord',
                'delegation' => 'Centre',
                'email' => 'technicien@senelec.sn',
                'password' => Hash::make('pass1234'),
            ],
            [
                'prenom' => 'Fatou',
                'nom' => 'Ba',
                'telephonne' => '770000002',
                'numeroCompteur' => 'COMP1002',
                'address' => 'Dakar',
                'role' => 'admin',
                'agence' => 'Dakar Plateau',
                'delegation' => 'Ouest',
                'email' => 'admin@senelec.sn',
                'password' => Hash::make('pass1234'),
            ],
            [
                'prenom' => 'Mamadou',
                'nom' => 'Diop',
                'telephonne' => '770000003',
                'numeroCompteur' => 'COMP1003',
                'address' => 'Saint-Louis',
                'role' => 'directeur',
                'agence' => 'Saint-Louis Centre',
                'delegation' => 'Nord',
                'email' => 'directeur@senelec.sn',
                'password' => Hash::make('pass1234'),
            ],
            [
                'prenom' => 'Awa',
                'nom' => 'Sow',
                'telephonne' => '770000004',
                'numeroCompteur' => 'COMP1004',
                'address' => 'Kaolack',
                'role' => 'client',
                'agence' => 'Kaolack Est',
                'delegation' => 'Centre',
                'email' => 'client@senelec.sn',
                'password' => Hash::make('pass1234'),
            ],
            [
                'prenom' => 'Ibrahima',
                'nom' => 'Ndoye',
                'telephonne' => '770000005',
                'numeroCompteur' => 'COMP1005',
                'address' => 'Ziguinchor',
                'role' => 'encadreur',
                'agence' => 'Ziguinchor Sud',
                'delegation' => 'Sud',
                'email' => 'encadreur@senelec.sn',
                'password' => Hash::make('pass1234'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

