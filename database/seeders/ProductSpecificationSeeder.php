<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Database\Seeder;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $specs = $this->getSpecificationsForProduct($product);
            
            foreach ($specs as $index => $spec) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'name' => $spec['name'],
                    'value' => $spec['value'],
                    'is_badge' => $spec['is_badge'] ?? false,
                    'sort_order' => $index,
                ]);
            }
        }
    }
    
    private function getSpecificationsForProduct($product)
    {
        $categoryName = $product->category->name ?? '';
        $productName = strtolower($product->name);
        
        // Spécifications par catégorie
        if (str_contains($categoryName, 'Téléphonie')) {
            return [
                ['name' => 'Écran', 'value' => '6.7 pouces AMOLED', 'is_badge' => true],
                ['name' => 'Processeur', 'value' => 'Octa-core', 'is_badge' => true],
                ['name' => 'RAM', 'value' => '8 Go', 'is_badge' => true],
                ['name' => 'Stockage', 'value' => '256 Go', 'is_badge' => true],
                ['name' => 'Batterie', 'value' => '5000 mAh', 'is_badge' => true],
                ['name' => 'Appareil photo', 'value' => '108 MP', 'is_badge' => true],
                ['name' => 'Système', 'value' => 'Android 13', 'is_badge' => false],
                ['name' => 'Réseau', 'value' => '5G', 'is_badge' => true],
            ];
        }
        
        if (str_contains($categoryName, 'Électroménager')) {
            if (str_contains($productName, 'réfrigérateur')) {
                return [
                    ['name' => 'Capacité', 'value' => '635 L', 'is_badge' => true],
                    ['name' => 'Classe énergétique', 'value' => 'A+', 'is_badge' => true],
                    ['name' => 'Type', 'value' => 'Side-by-Side', 'is_badge' => true],
                    ['name' => 'Niveau sonore', 'value' => '38 dB', 'is_badge' => false],
                    ['name' => 'Dimensions', 'value' => '91 x 179 x 73 cm', 'is_badge' => false],
                ];
            }
            
            if (str_contains($productName, 'machine à laver')) {
                return [
                    ['name' => 'Capacité', 'value' => '10 kg', 'is_badge' => true],
                    ['name' => 'Vitesse d\'essorage', 'value' => '1400 tr/min', 'is_badge' => true],
                    ['name' => 'Classe énergétique', 'value' => 'A+++', 'is_badge' => true],
                    ['name' => 'Moteur', 'value' => 'Inverter', 'is_badge' => true],
                    ['name' => 'Programmes', 'value' => '15', 'is_badge' => false],
                ];
            }
            
            if (str_contains($productName, 'climatiseur')) {
                return [
                    ['name' => 'Puissance', 'value' => '18000 BTU', 'is_badge' => true],
                    ['name' => 'Surface', 'value' => '45 m²', 'is_badge' => true],
                    ['name' => 'Classe énergétique', 'value' => 'A++', 'is_badge' => true],
                    ['name' => 'Type', 'value' => 'Inverter', 'is_badge' => true],
                    ['name' => 'Niveau sonore', 'value' => '35 dB', 'is_badge' => false],
                ];
            }
        }
        
        if (str_contains($categoryName, 'Informatique')) {
            if (str_contains($productName, 'pc portable')) {
                return [
                    ['name' => 'Processeur', 'value' => 'Intel Core i7', 'is_badge' => true],
                    ['name' => 'RAM', 'value' => '16 Go', 'is_badge' => true],
                    ['name' => 'Stockage', 'value' => '512 Go SSD', 'is_badge' => true],
                    ['name' => 'Écran', 'value' => '15.6" Full HD', 'is_badge' => true],
                    ['name' => 'Carte graphique', 'value' => 'Intel Iris Xe', 'is_badge' => false],
                    ['name' => 'Système', 'value' => 'Windows 11', 'is_badge' => true],
                ];
            }
            
            if (str_contains($productName, 'gaming')) {
                return [
                    ['name' => 'Processeur', 'value' => 'AMD Ryzen 9', 'is_badge' => true],
                    ['name' => 'RAM', 'value' => '16 Go', 'is_badge' => true],
                    ['name' => 'Stockage', 'value' => '1 To SSD', 'is_badge' => true],
                    ['name' => 'Carte graphique', 'value' => 'NVIDIA RTX 3060', 'is_badge' => true],
                    ['name' => 'Écran', 'value' => '15.6" 144Hz', 'is_badge' => true],
                    ['name' => 'Refroidissement', 'value' => 'Liquid', 'is_badge' => false],
                ];
            }
        }
        
        if (str_contains($categoryName, 'Photo')) {
            return [
                ['name' => 'Capteur', 'value' => '32.5 MP', 'is_badge' => true],
                ['name' => 'Vidéo', 'value' => '4K', 'is_badge' => true],
                ['name' => 'Écran', 'value' => '3.2" Tactile', 'is_badge' => true],
                ['name' => 'Connexion', 'value' => 'Wi-Fi/Bluetooth', 'is_badge' => true],
                ['name' => 'Viseur', 'value' => 'Optique', 'is_badge' => false],
            ];
        }
        
        if (str_contains($categoryName, 'Réseaux')) {
            return [
                ['name' => 'Débit', 'value' => 'AX5400', 'is_badge' => true],
                ['name' => 'Wi-Fi', 'value' => '6', 'is_badge' => true],
                ['name' => 'Antennes', 'value' => '6', 'is_badge' => true],
                ['name' => 'Ports', 'value' => '1x 2.5G', 'is_badge' => false],
                ['name' => 'Sécurité', 'value' => 'WPA3', 'is_badge' => true],
            ];
        }
        
        // Spécifications par défaut
        return [
            ['name' => 'Garantie', 'value' => '1 an', 'is_badge' => true],
            ['name' => 'Origine', 'value' => 'Importé', 'is_badge' => false],
            ['name' => 'Livraison', 'value' => '24-48h', 'is_badge' => true],
        ];
    }
}