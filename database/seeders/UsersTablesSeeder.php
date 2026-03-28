<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Personnel;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsersTablesSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer le rôle admin (créé par PermissionsRolesSeeder)
        $adminRole = Role::where('name', 'admin')->first();
        
        if (!$adminRole) {
            $this->command->error('❌ Le rôle admin n\'existe pas. Exécutez d\'abord PermissionsRolesSeeder');
            return;
        }

        $password = 'abs@2026';

        try {
            DB::beginTransaction();

            // Admin principal
            $existingUser = User::where('email', 'danielaholonou@gmail.com')->first();

            if (!$existingUser) {
                $personnel = Personnel::create([
                    'nom'                   => 'Admin',
                    'prenoms'               => 'Good',
                    'date_naissance'        => '1990-01-01',
                    'genre'                 => 'Homme',
                    'adresse'               => 'France',
                    'telephone'             => '+330194356464',
                    'email'                 => 'danielaholonou@gmail.com',
                    'ville_de_residence'    => 'Cotonou',
                    'nationalite'           => 'Française',
                    'code_postal'           => '00229',
                    'photo_profil'          => '',
                    'statut_profil'         => '1',
                    'a_propos'              => "Compte de l'administrateur principal.",
                ]);

                $admin = User::create([
                    'name'          => 'Admin',
                    'email'         => 'danielaholonou@gmail.com',
                    'password'      => bcrypt($password),
                    'role_id'       => $adminRole->id,
                    'personnel_id'  => $personnel->id,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);

                $admin->assignRole($adminRole);
                
                $this->command->info('✅ Admin principal créé');
            }


            DB::commit();

            $this->command->info('✅ Utilisateurs créés avec succès :');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Erreur : ' . $e->getMessage());
            Log::error('Erreur UsersTablesSeeder: ' . $e->getMessage());
        }
    }
}