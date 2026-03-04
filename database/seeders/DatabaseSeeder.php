<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsRolesSeeder::class,
            UsersTablesSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,           
            ProductSeeder::class,         
            ColorSeeder::class,             
            ProductColorSeeder::class,      
            ProductSpecificationSeeder::class,
        ]);
    }
}
