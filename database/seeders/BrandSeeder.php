<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            // Téléphonie & Électronique
            ['name' => 'Samsung', 'status' => 1],
            ['name' => 'Apple', 'status' => 1],
            ['name' => 'Huawei', 'status' => 1],
            ['name' => 'Xiaomi', 'status' => 1],
            
            // Électroménager
            ['name' => 'Sharp', 'status' => 1],
            ['name' => 'LG', 'status' => 1],
            ['name' => 'Sony', 'status' => 1],
            ['name' => 'Panasonic', 'status' => 1],
            ['name' => 'Philips', 'status' => 1],
            
            // Informatique
            ['name' => 'HP', 'status' => 1],
            ['name' => 'Lenovo', 'status' => 1],
            
            
            // Routeurs & Réseaux
            ['name' => 'Cisco', 'status' => 1],
            ['name' => 'TP-Link', 'status' => 1],
            ['name' => 'D-Link', 'status' => 1],
            ['name' => 'MikroTik', 'status' => 1],
            
            // Appareils photo
            ['name' => 'Canon', 'status' => 1],
            ['name' => 'Nikon', 'status' => 1],
            
            // Marques supplémentaires
            ['name' => 'Tecno', 'status' => 1],
        ];

        // ✅ Utiliser TOUTES les marques, pas seulement $topBrands
        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'status' => $brand['status'],
            ]);
        }
    }
}