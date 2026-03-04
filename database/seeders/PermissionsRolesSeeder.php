<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsRolesSeeder extends Seeder
{
    public function run()
    {
        // Reset cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            // ── Dashboard ────────────────────────────────────────────────────
            ['name' => 'view dashboard',              'description' => 'Voir le tableau de bord'],

            // ── Produits (sidebar : Gestion des articles) ────────────────────
            ['name' => 'view products',               'description' => 'Voir la liste des produits'],
            ['name' => 'create product',              'description' => 'Créer un produit'],
            ['name' => 'edit product',                'description' => 'Modifier un produit'],
            ['name' => 'delete product',              'description' => 'Supprimer un produit'],
            ['name' => 'publish product',             'description' => 'Publier / archiver un produit'],

            // ── Commandes ────────────────────────────────────────────────────
            ['name' => 'view orders',                 'description' => 'Voir la liste des commandes en cours'],
            ['name' => 'view order detail',           'description' => 'Voir le détail d\'une commande'],
            ['name' => 'update order status',         'description' => 'Changer le statut d\'une commande'],
            ['name' => 'start order processing',      'description' => 'Confirmer et démarrer le traitement d\'une commande'],
            ['name' => 'mark order paid',             'description' => 'Marquer une commande comme payée'],
            ['name' => 'view order history',          'description' => 'Voir l\'historique (livrées, annulées, remboursées)'],

            // ── Marques ──────────────────────────────────────────────────────
            ['name' => 'view brands',                 'description' => 'Voir la liste des marques'],
            ['name' => 'create brand',                'description' => 'Ajouter une marque'],
            ['name' => 'edit brand',                  'description' => 'Modifier une marque'],
            ['name' => 'delete brand',                'description' => 'Supprimer une marque'],
            ['name' => 'activate brand',              'description' => 'Activer une marque désactivée'],
            ['name' => 'deactivate brand',            'description' => 'Désactiver une marque active'],

            // ── Catégories ───────────────────────────────────────────────────
            ['name' => 'view categories',             'description' => 'Voir la liste des catégories'],
            ['name' => 'create category',             'description' => 'Ajouter une catégorie'],
            ['name' => 'edit category',               'description' => 'Modifier une catégorie'],
            ['name' => 'delete category',             'description' => 'Supprimer une catégorie'],
            ['name' => 'activate category',           'description' => 'Activer une catégorie désactivée'],
            ['name' => 'deactivate category',         'description' => 'Désactiver une catégorie active'],

            // ── Rôles ────────────────────────────────────────────────────────
            ['name' => 'view roles',                  'description' => 'Voir la liste des rôles'],
            ['name' => 'create role',                 'description' => 'Créer un rôle'],
            ['name' => 'edit role',                   'description' => 'Modifier un rôle et ses permissions'],
            ['name' => 'delete role',                 'description' => 'Supprimer un rôle'],
            ['name' => 'activate role',               'description' => 'Activer un rôle désactivé'],
            ['name' => 'deactivate role',             'description' => 'Désactiver un rôle actif'],

            // ── Utilisateurs ─────────────────────────────────────────────────
            ['name' => 'view users',                  'description' => 'Voir la liste des utilisateurs'],
            ['name' => 'create user',                 'description' => 'Créer un utilisateur'],
            ['name' => 'edit user',                   'description' => 'Modifier un utilisateur'],
            ['name' => 'delete user',                 'description' => 'Supprimer un utilisateur'],
            ['name' => 'activate user',               'description' => 'Activer un utilisateur'],
            ['name' => 'deactivate user',             'description' => 'Désactiver un utilisateur'],
            ['name' => 'assign role to user',         'description' => 'Attribuer un rôle à un utilisateur lors de l\'activation'],

            // ── Notifications ────────────────────────────────────────────────
            ['name' => 'view notifications',          'description' => 'Voir les notifications admin (navbar)'],
            ['name' => 'mark notifications read',     'description' => 'Marquer les notifications comme lues'],

            // ── Profil ───────────────────────────────────────────────────────
            // ['name' => 'view profile',                'description' => 'Voir son propre profil'],
            // ['name' => 'edit profile',                'description' => 'Modifier son propre profil'],

        ];

        // ── Création des permissions ──────────────────────────────────────────
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'description' => $permission['description'],
                    'guard_name'  => 'web',
                ]
            );
        }

        $this->command->info('✅ ' . count($permissions) . ' permissions créées/mises à jour.');

        // ════════════════════════════════════════════════════════════════════
        // RÔLES
        // ════════════════════════════════════════════════════════════════════

        // ── Admin — toutes les permissions ───────────────────────────────────
        $adminRole = Role::updateOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web']
        );
        $adminRole->syncPermissions(Permission::all());

        // ── Gestionnaire commandes ────────────────────────────────────────────
        $gestionnaireCommandes = Role::updateOrCreate(
            ['name' => 'Gestionnaire commandes'],
            ['guard_name' => 'web']
        );
        $gestionnaireCommandes->syncPermissions([
            'view dashboard',
            'view orders',
            'view order detail',
            'update order status',
            'start order processing',
            'mark order paid',
            'view order history',
            'view notifications',
            'mark notifications read',
            // 'view profile',
            // 'edit profile',
        ]);

        // ── Gestionnaire produits ─────────────────────────────────────────────
        $gestionnaireProduits = Role::updateOrCreate(
            ['name' => 'Gestionnaire produits'],
            ['guard_name' => 'web']
        );
        $gestionnaireProduits->syncPermissions([
            'view dashboard',
            'view products',
            'create product',
            'edit product',
            'delete product',
            'publish product',
            'view brands',
            'create brand',
            'edit brand',
            'activate brand',
            'deactivate brand',
            'view categories',
            'create category',
            'edit category',
            'activate category',
            'deactivate category',
            'view notifications',
            'mark notifications read',
            // 'view profile',
            // 'edit profile',
        ]);

        // ── Comptable ─────────────────────────────────────────────────────────
        $comptable = Role::updateOrCreate(
            ['name' => 'Comptable'],
            ['guard_name' => 'web']
        );
        $comptable->syncPermissions([
            'view dashboard',
            'view orders',
            'view order detail',
            'mark order paid',
            'view order history',
            // 'view profile',
            // 'edit profile',
        ]);

        // ── Résumé ────────────────────────────────────────────────────────────
        $this->command->info('');
        $this->command->table(
            ['Rôle', 'Permissions attribuées'],
            [
                ['admin',                   $adminRole->permissions()->count()],
                ['Gestionnaire commandes',  $gestionnaireCommandes->permissions()->count()],
                ['Gestionnaire produits',   $gestionnaireProduits->permissions()->count()],
                ['Comptable',               $comptable->permissions()->count()],
            ]
        );
        $this->command->info('✅ Rôles créés et permissions assignées avec succès.');
    }
}