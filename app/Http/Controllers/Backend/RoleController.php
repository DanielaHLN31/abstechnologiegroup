<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Auth;

class RoleController extends Controller
{
    //
    public function AllRoles(){

        //

        // Variable pour déterminé l'entité Tribunal de l'utilisateur
        $users = Auth::user();


            $permissions = Permission::latest()->get();
            $roles = Role::latest()->get();



        return view('backend.role.all', compact('permissions', 'roles'))/*->with($notification)*/;
    }

    public function StoreRoles(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name', // Nom du rôle
            'permissions' => 'required|array',                   // Vérifie que 'permissions' est un tableau
            'permissions.*' => 'exists:permissions,name',        // Vérifie que chaque permission existe dans la table 'permissions' (via son nom)
        ], [
            'name.required' => 'Le champ nom est obligatoire.',
            'name.unique' => 'Ce nom de rôle existe déjà.',
            'name.max' => 'Le nom ne doit pas dépasser 50 caractères.',
            'permissions.required' => 'Sélectionnez au moins une permission.',
            'permissions.*.exists' => 'Une des permissions sélectionnées est invalide.',
        ]);

        try {

            DB::beginTransaction();

                // Création du rôle
                $role = Role::create([
                    'name' => $validatedData['name'],
                    'guard_name' => 'web', // Spécifie le guard
                ]);

                // Vérifie si le rôle a été correctement créé
                if (!$role) {
                    return redirect()->back()->withErrors('Erreur lors de la création du rôle. Veuillez réessayer.');
                }

                $role->givePermissionTo(array_unique($validatedData['permissions']));

            DB::commit();
            return response()->json([
                'message' => 'Le rôle a été créé avec succès.',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.roles'),
            ]);


        } catch (ValidationException $e) {
            // En cas d'erreur
            DB::rollBack();
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // En cas d'erreur
            DB::rollBack();
            return response()->json([
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function EditRoles($roleId)
    {
        // Récupérer le rôle avec ses permissions associées
        $role = Role::with('permissions')->findOrFail($roleId);

        // Récupérer les noms des permissions au lieu des IDs
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return response()->json([
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function UpdateRoles(Request $request) {

        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                // Ajoutez l'ID du rôle actuel pour ignorer sa propre unicité
                'unique:roles,name,' . $request->input('role_id') // Assurez-vous d'avoir un champ caché role_id dans votre formulaire
            ],
            'role_id' => 'required|exists:roles,id',
            'permissions_edit' => 'required|array',
            'permissions_edit.*' => 'exists:permissions,name', // Validez par ID plutôt que par nom
        ], [
            'name.required' => 'Le champ nom est obligatoire.',
            'name.unique' => 'Ce nom de rôle existe déjà.',
            'permissions_edit.required' => 'Sélectionnez au moins une permission.',
            'permissions_edit.*.exists' => 'Une des permissions sélectionnées est invalide.',
        ]);


        try {

            DB::beginTransaction();

            $role_id = $request->input('role_id');

            // Récupérer le rôle
            $role = Role::findOrFail($role_id);



            // Mettre à jour le nom du rôle
            $role->update([
                'name' => $validatedData['name'],
                'guard_name' => 'web', // Spécifie le guard
            ]);


            $role->syncPermissions(array_unique($validatedData['permissions_edit']));

            DB::commit();
            return response()->json([
                'message' => 'Le rôle a été modifié avec succès.',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.roles'),
            ]);


        } catch (ValidationException $e) {
            // En cas d'erreur
            DB::rollBack();
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // En cas d'erreur
            DB::rollBack();
            return response()->json([
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function DeleteRoles($roleId)
    {
        try {
            // Trouver le rôle
            $role = Role::findOrFail($roleId);

            // Vérifier s'il a des permissions et les détacher
            $role->permissions()->detach();

            if ($role->used == 1) {
                $nombreRoles = DB::table('users')
                    ->where('role_id', $roleId)
                    ->count();

                $message = $nombreRoles > 0
                    ? "Impossible de supprimer ce role car il est actuellement assigné à {$nombreRoles} utilisateur(s)."
                    : "Impossible de supprimer ce role car il est actuellement utilisé dans le système.";

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }

            // Supprimer le rôle
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rôle et permissions associées supprimés avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du rôle : ' . $e->getMessage(),
            ], 500);
        }
    }


    public function InactiveRoles($id){
        Role::findOrFail($id)->update(['status' => 0]);

        return response()->json([
            'message' => 'Le Role est désactivé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.roles'),
        ]);
    }// end method



    public function ActiveRoles($id){
        Role::findOrFail($id)->update(['status' => 1]);

        return response()->json([
            'message' => 'Le Role est activé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.roles'),
        ]);
    }// end method



}
