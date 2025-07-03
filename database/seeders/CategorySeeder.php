<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'Coupure d’électricité'],
            ['nom' => 'Facturation'],
            ['nom' => 'Dysfonctionnement compteur'],
            ['nom' => 'Service client'],
        ];

        Category::insert($categories);
    }
}
