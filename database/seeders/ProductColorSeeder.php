<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $colors = Color::all();
        
        foreach ($products as $product) {
            $categoryName = $product->category->name ?? '';
            
            // Nombre de couleurs à attribuer selon la catégorie
            $colorCount = rand(1, 4);
            
            // Sélectionner des couleurs aléatoires
            $randomColors = $colors->random(min($colorCount, $colors->count()));
            
            $colorData = [];
            foreach ($randomColors as $color) {
                // Stock aléatoire pour chaque couleur
                $stockQuantity = rand(5, 30);
                
                $colorData[$color->id] = [
                    'stock_quantity' => $stockQuantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Attacher les couleurs au produit
            $product->colors()->sync($colorData);
        }
    }
}