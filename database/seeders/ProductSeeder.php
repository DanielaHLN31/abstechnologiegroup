<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des marques et catégories existantes
        $brands = Brand::pluck('id', 'name')->toArray();
        $categories = Category::pluck('id', 'name')->toArray();

        $products = [
            // TÉLÉPHONIE - Smartphones
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'description' => 'Le Samsung Galaxy S23 Ultra est le smartphone ultime avec son appareil photo 200MP, son écran Dynamic AMOLED 2X de 6.8 pouces et son processeur Snapdragon 8 Gen 2. Batterie 5000mAh, 12GB RAM, 256GB stockage.',
                'brand' => 'Samsung',
                'category' => 'Téléphonie',
                'price' => 899000,
                'stock_quantity' => 25,
                'in_stock' => true,
                'low_stock_threshold' => 5,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'Samsung Galaxy S23 Ultra 256GB - Acheter au meilleur prix',
                'meta_description' => 'Découvrez le Samsung Galaxy S23 Ultra avec appareil photo 200MP, écran 6.8 pouces et batterie 5000mAh. Livraison rapide partout en Côte d\'Ivoire.',
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => "L'iPhone 15 Pro Max avec sa nouvelle coque en titane, sa puce A17 Pro et son système photo professionnel. Écran Super Retina XDR 6.7 pouces, 256GB, appareil photo principal 48MP.",
                'brand' => 'Apple',
                'category' => 'Téléphonie',
                'price' => 1250000,
                'stock_quantity' => 15,
                'in_stock' => true,
                'low_stock_threshold' => 3,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'iPhone 15 Pro Max 256GB - Apple - Achat pas cher',
                'meta_description' => "iPhone 15 Pro Max avec puce A17 Pro et appareil photo 48MP. Profitez de la meilleure expérience smartphone avec ABS Technologie.",
            ],
            [
                'name' => 'Xiaomi Redmi Note 13 Pro',
                'description' => 'Xiaomi Redmi Note 13 Pro avec appareil photo 200MP, écran AMOLED 120Hz 6.67 pouces, batterie 5000mAh et charge rapide 67W. 8GB RAM, 256GB stockage.',
                'brand' => 'Xiaomi',
                'category' => 'Téléphonie',
                'price' => 325000,
                'stock_quantity' => 40,
                'in_stock' => true,
                'low_stock_threshold' => 10,
                'status' => 'published',
                'is_featured' => false,
                'meta_title' => 'Xiaomi Redmi Note 13 Pro 256GB - Smartphone pas cher',
                'meta_description' => 'Xiaomi Redmi Note 13 Pro avec appareil photo 200MP et charge rapide 67W. Le meilleur rapport qualité-prix du marché.',
            ],
            [
                'name' => 'Huawei P60 Pro',
                'description' => 'Huawei P60 Pro avec appareil photo Ultra Aperture XMAGE, écran LTPO OLED 120Hz 6.67 pouces, batterie 4815mAh et charge rapide 88W. 8GB RAM, 256GB.',
                'brand' => 'Huawei',
                'category' => 'Téléphonie',
                'price' => 685000,
                'stock_quantity' => 12,
                'in_stock' => true,
                'low_stock_threshold' => 3,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'Huawei P60 Pro 256GB - Appareil photo XMAGE',
                'meta_description' => 'Huawei P60 Pro avec technologie d\'imagerie XMAGE pour des photos exceptionnelles. Découvrez-le chez ABS Technologie.',
            ],
            [
                'name' => 'Tecno Camon 20 Premier',
                'description' => 'Tecno Camon 20 Premier avec appareil photo RGBW 108MP, écran AMOLED 120Hz 6.78 pouces et batterie 5000mAh. 8GB RAM, 512GB stockage.',
                'brand' => 'Tecno',
                'category' => 'Téléphonie',
                'price' => 275000,
                'stock_quantity' => 30,
                'in_stock' => true,
                'low_stock_threshold' => 8,
                'status' => 'published',
                'is_featured' => false,
                'meta_title' => 'Tecno Camon 20 Premier 512GB - Smartphone photo',
                'meta_description' => 'Tecno Camon 20 Premier avec appareil photo 108MP pour des clichés professionnels. Livraison rapide en Côte d\'Ivoire.',
            ],

            // ÉLECTROMÉNAGER
            [
                'name' => 'Réfrigérateur Samsung Side-by-Side 635L',
                'description' => 'Réfrigérateur Samsung Side-by-Side 635L avec technologie Twin Cooling Plus, distributeur d\'eau, éclairage LED et compartiment congélateur spacieux. Classe énergétique A+.',
                'brand' => 'Samsung',
                'category' => 'Électroménager',
                'price' => 1150000,
                'stock_quantity' => 8,
                'in_stock' => true,
                'low_stock_threshold' => 2,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'Réfrigérateur Samsung Side-by-Side 635L - Grande capacité',
                'meta_description' => 'Réfrigérateur Samsung 635L avec technologie Twin Cooling. Idéal pour les grandes familles. Livraison et installation incluses.',
            ],
            [
                'name' => 'Machine à laver LG Inverter 10kg',
                'description' => 'Machine à laver LG Inverter 10kg avec moteur direct drive, technologie AI DD, vapeur et Wi-Fi. Silencieuse, économe et durable.',
                'brand' => 'LG',
                'category' => 'Électroménager',
                'price' => 495000,
                'stock_quantity' => 15,
                'in_stock' => true,
                'low_stock_threshold' => 4,
                'status' => 'published',
                'is_featured' => false,
                'meta_title' => 'Machine à laver LG Inverter 10kg - Direct Drive',
                'meta_description' => 'Machine à laver LG 10kg avec moteur direct drive garanti 10 ans. Efficacité et silence. Livraison rapide.',
            ],
            [
                'name' => 'Climatiseur Sharp Inverter 18000 BTU',
                'description' => 'Climatiseur Sharp Inverter 18000 BTU avec filtre plasmacluster, mode économie d\'énergie, télécommande et minuterie programmable. Idéal pour les grandes pièces.',
                'brand' => 'Sharp',
                'category' => 'Électroménager',
                'price' => 685000,
                'stock_quantity' => 10,
                'in_stock' => true,
                'low_stock_threshold' => 3,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'Climatiseur Sharp Inverter 18000 BTU - Plasmacluster',
                'meta_description' => 'Climatiseur Sharp 18000 BTU avec technologie Inverter et filtre plasmacluster. Installation disponible.',
            ],
            [
                'name' => 'Four micro-ondes Panasonic 27L',
                'description' => 'Four micro-ondes Panasonic 27L avec fonction inverter, grill et chaleur tournante. 6 niveaux de puissance, plateau tournant 34cm.',
                'brand' => 'Panasonic',
                'category' => 'Électroménager',
                'price' => 165000,
                'stock_quantity' => 20,
                'in_stock' => true,
                'low_stock_threshold' => 5,
                'status' => 'published',
                'is_featured' => false,
                'meta_title' => 'Four micro-ondes Panasonic 27L - Inverter',
                'meta_description' => 'Micro-ondes Panasonic 27L avec technologie Inverter pour une cuisson homogène. Pratique et efficace.',
            ],
            [
                'name' => 'Aspirateur Philips PowerPro',
                'description' => 'Aspirateur Philips PowerPro avec technologie PowerCyclone 7, filtre HEPA, puissance 2100W et sac XXL. Accessoires inclus.',
                'brand' => 'Philips',
                'category' => 'Électroménager',
                'price' => 125000,
                'stock_quantity' => 25,
                'in_stock' => true,
                'low_stock_threshold' => 7,
                'status' => 'published',
                'is_featured' => false,
                'meta_title' => 'Aspirateur Philips PowerPro - Puissance 2100W',
                'meta_description' => 'Aspirateur Philips PowerPro avec cyclone et filtre HEPA. Idéal pour un nettoyage en profondeur.',
            ],

            // INFORMATIQUE
            [
                'name' => 'PC Portable HP Pavilion 15',
                'description' => 'PC Portable HP Pavilion 15 avec processeur Intel Core i7, 16GB RAM, 512GB SSD, écran 15.6" Full HD, Windows 11. Idéal pour le travail et le divertissement.',
                'brand' => 'HP',
                'category' => 'Informatique',
                'price' => 695000,
                'stock_quantity' => 12,
                'in_stock' => true,
                'low_stock_threshold' => 3,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'PC Portable HP Pavilion 15 Core i7 16GB RAM',
                'meta_description' => 'PC HP Pavilion 15 avec processeur i7, 16GB RAM et SSD 512GB. Parfait pour les professionnels et étudiants.',
            ],
            [
                'name' => 'PC Gaming Asus ROG Strix G15',
                'description' => 'PC Gaming Asus ROG Strix G15 avec processeur AMD Ryzen 9, NVIDIA RTX 3060, 16GB RAM, 1TB SSD, écran 15.6" 144Hz. Refroidissement avancé.',
                'brand' => 'Asus',
                'category' => 'Informatique',
                'price' => 1245000,
                'stock_quantity' => 5,
                'in_stock' => true,
                'low_stock_threshold' => 1,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'PC Gaming Asus ROG Strix G15 RTX 3060 - Ryzen 9',
                'meta_description' => 'PC gamer Asus ROG Strix avec RTX 3060 et Ryzen 9. Pour les joueurs exigeants. Stock limité.',
            ],
            [
                'name' => 'Tablette Lenovo Tab P11 Pro',
                'description' => 'Tablette Lenovo Tab P11 Pro avec écran OLED 11.5 pouces, processeur Snapdragon, 6GB RAM, 128GB stockage, 4 haut-parleurs JBL. Idéale pour le multimédia.',
                'brand' => 'Lenovo',
                'category' => 'Informatique',
                'price' => 295000,
                'stock_quantity' => 18,
                'in_stock' => true,
                'low_stock_threshold' => 5,
                'status' => 'published',
                'is_featured' => false,
                'meta_title' => 'Tablette Lenovo Tab P11 Pro - Écran OLED',
                'meta_description' => 'Tablette Lenovo avec écran OLED et son JBL. Parfaite pour les films et la navigation.',
            ],

            // PHOTO & CAMÉRA
            [
                'name' => 'Appareil photo Canon EOS 90D',
                'description' => 'Appareil photo reflex Canon EOS 90D avec capteur 32.5MP, vidéo 4K, écran tactile orientable, viseur optique, Wi-Fi et Bluetooth. Idéal pour les passionnés.',
                'brand' => 'Canon',
                'category' => 'Photo & Caméra',
                'price' => 945000,
                'stock_quantity' => 7,
                'in_stock' => true,
                'low_stock_threshold' => 2,
                'status' => 'published',
                'is_featured' => true,
                'meta_title' => 'Appareil photo Canon EOS 90D - Reflex 32.5MP',
                'meta_description' => 'Canon EOS 90D avec capteur 32.5MP et vidéo 4K. Le reflex idéal pour les photographes exigeants.',
            ],

            // RÉSEAUX
            [
                'name' => 'Routeur TP-Link Archer AX73',
                'description' => 'Routeur Wi-Fi 6 TP-Link Archer AX73 avec vitesse AX5400, 6 antennes, port 2.5G, sécurité avancée. Idéal pour le gaming et le streaming 4K.',
                'brand' => 'TP-Link',
                'category' => 'Réseaux & Connectivité',
                'price' => 125000,
                'stock_quantity' => 22,
                'in_stock' => true,
                'low_stock_threshold' => 6,
                'status' => 'published',
                'is_featured' => false,
                'meta_title' => 'Routeur Wi-Fi 6 TP-Link Archer AX73 - AX5400',
                'meta_description' => 'Routeur TP-Link AX73 avec Wi-Fi 6 pour des débits ultra-rapides. Parfait pour toute la maison.',
            ],
        ];

        foreach ($products as $productData) {
            $brandId = $brands[$productData['brand']] ?? null;
            $categoryId = $categories[$productData['category']] ?? null;
            
            if (!$brandId || !$categoryId) {
                continue; // Ignorer si la marque ou catégorie n'existe pas
            }

            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']) . '-' . uniqid(),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'brand_id' => $brandId,
                'category_id' => $categoryId,
                'stock_quantity' => $productData['stock_quantity'],
                'in_stock' => $productData['in_stock'],
                'low_stock_threshold' => $productData['low_stock_threshold'],
                'status' => $productData['status'],
                'is_featured' => $productData['is_featured'],
                'meta_title' => $productData['meta_title'],
                'meta_description' => $productData['meta_description'],
            ]);
        }
    }
}