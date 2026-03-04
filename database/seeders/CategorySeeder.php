<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Téléphonie',
                'description' => 'Smartphones, téléphones portables et accessoires',
                'status' => 1,
            ],
            [
                'name' => 'Électroménager',
                'description' => 'Appareils électroménagers pour la maison.',
                'status' => 1,
            ],
            [
                'name' => 'Informatique',
                'description' => 'Ordinateurs, PC portables, tablettes et périphériques',
                'status' => 1,
            ],
            [
                'name' => 'Photo & Caméra',
                'description' => 'Appareils photo, caméras, objectifs et accessoires vidéo',
                'status' => 1,
            ],
            [
                'name' => 'Réseaux & Connectivité',
                'description' => 'Routeurs, modems, switches et équipements réseau',
                'status' => 1,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'status' => $category['status'],
            ]);
        }
    }
}