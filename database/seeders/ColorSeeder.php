<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            // Couleurs de base
            ['name' => 'Noir', 'code' => '#000000',],
            ['name' => 'Blanc', 'code' => '#FFFFFF',],
            ['name' => 'Gris', 'code' => '#808080',],
            ['name' => 'Argent', 'code' => '#C0C0C0',],
            ['name' => 'Or', 'code' => '#FFD700',],
            
            // Couleurs pour smartphones
            ['name' => 'Or Rose', 'code' => '#FCC9B9',],
            ['name' => 'Bleu Nuit', 'code' => '#0B3B5C',],
            ['name' => 'Vert Forêt', 'code' => '#228B22',],
            ['name' => 'Rouge', 'code' => '#FF0000',],
            ['name' => 'Violet', 'code' => '#800080',],
            
            // Couleurs pour électroménager
            ['name' => 'Inox', 'code' => '#C0C0C0',],
            ['name' => 'Beige', 'code' => '#F5F5DC',],
            ['name' => 'Bleu Glacier', 'code' => '#A7C7E7',],
            ['name' => 'Noir Mat', 'code' => '#2C2C2C',],
            ['name' => 'Blanc Cassé', 'code' => '#F5F5F5',],
            
            // Couleurs spéciales
            ['name' => 'Bleu', 'code' => '#0000FF',],
            ['name' => 'Vert', 'code' => '#00FF00',],
            ['name' => 'Jaune', 'code' => '#FFFF00',],
            ['name' => 'Orange', 'code' => '#FFA500',],
            ['name' => 'Marron', 'code' => '#8B4513',],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}