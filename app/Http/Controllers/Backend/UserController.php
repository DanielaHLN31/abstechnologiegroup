<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
// use App\Jobs\SendUserWelcomeEmailJob;
use App\Models\Personnel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function AllUsers()
    {
        $query = User::whereNotNull('personnel_id')->latest();

        $users = $query->get();

        $roles = Role::where('status', '1')->orderBy('name', 'ASC')->get();

        return view('backend.user.user_all', compact('roles', 'users'));
    }

    // Fonction pour ajouter un utilisateur
    public function StoreUsers(Request $request)
    {
        Log::info('Début de la création d\'un utilisateur.', ['request_data' => $request->all()]);

        // Validation des données
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'code_postal' => 'nullable|string|max:12',
            'date_naissance' => 'nullable|string|date_format:d-m-Y',
            'genre' => 'required|string|in:Homme,Femme',
            'nationalite' => 'required|string|max:255',
            'ville_de_residence' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'a_propos' => 'nullable|string|max:1000',
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            // Validations pour les informations de connexion
            'username.required' => 'Le nom d\'utilisateur est obligatoire',
            'username.string' => 'Le nom d\'utilisateur doit être une chaîne de caractères',
            'username.max' => 'Le nom d\'utilisateur ne doit pas dépasser 255 caractères',

            'email.required' => 'L\'adresse email est obligatoire',
            'email.email' => 'L\'adresse email doit être valide',
            'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères',
            'email.unique' => 'Cette adresse email est déjà utilisée',

            // Validations pour les informations personnelles
            'lastname.required' => 'Le nom est obligatoire',
            'lastname.string' => 'Le nom doit être une chaîne de caractères',
            'lastname.max' => 'Le nom ne doit pas dépasser 255 caractères',

            'firstname.required' => 'Le(s) prénom(s) est/sont obligatoire(s)',
            'firstname.string' => 'Le(s) prénom(s) doit/doivent être une chaîne de caractères',
            'firstname.max' => 'Le(s) prénom(s) ne doit/doivent pas dépasser 255 caractères',

            'telephone.required' => 'Le numéro de téléphone est obligatoire',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères',
            'telephone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères',

            'code_postal.max' => 'Le code postal ne doit pas dépasser 12 caractères',

            'genre.in' => 'Le genre doit être soit Homme soit Femme',
            'genre.required' => 'Le genre doit est obligatoire',

            'nationalite.max' => 'La nationalité ne doit pas dépasser 255 caractères',
            'nationalite.required' => 'La nationalité est obligatoire',

            'ville_de_residence.max' => 'La ville de résidence ne doit pas dépasser 255 caractères',
            'ville_de_residence.required' => 'La ville de résidence est obligatire',

            'adresse.max' => 'L\'adresse ne doit pas dépasser 255 caractères',
            'adresse.required' => 'L\'adresse est obligatoire',

            // Validations pour les qualités professionnelles
            'a_propos.max' => 'La biographie ne doit pas dépasser 1000 caractères'
        ]);

        DB::beginTransaction();
        try {
            // Gestion conditionnelle de la date de naissance
            $dateNaissance = null;
            if ($request->filled('date_naissance')) {
                $dateNaissance = Carbon::createFromFormat('d-m-Y', $request->date_naissance)->format('Y-m-d');
            }

            // Gestion de la photo de profil avec Storage
            $photo_profil = null;
            if ($request->hasFile('photo_profil')) {
                $image = $request->file('photo_profil');
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                
                // Stockage dans storage/app/public/upload/user_images/
                $path = $image->storeAs('public/upload/user_images', $name_gen);
                
                // Nom du fichier à sauvegarder en base de données
                $photo_profil = $name_gen;
            }

            $personnel = Personnel::create([
                'nom' => $request->lastname,
                'prenoms' => $request->firstname,
                'date_naissance' => $dateNaissance,
                'genre' => $request->genre,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'ville_de_residence' => $request->ville_de_residence,
                'code_postal' => $request->code_postal,
                'nationalite' => $request->nationalite,
                'a_propos' => $request->a_propos,
                'photo_profil' => $photo_profil,
                'statut_profil' => 1,
            ]);
            Log::info('Personnel créé avec succès', ['personnel_id' => $personnel->id]);

            // Création de l'utilisateur avec l'affectation automatique
            $userData = [
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make('CLEAN'),
                'role_id' => $request->role_id,
                'personnel_id' => $personnel->id,
                'status' => 1,
            ];
            $user = User::create($userData);
            Log::info('Utilisateur créé avec succès', ['user_id' => $user->id]);

            // Attribution du rôle
            $role = Role::findOrFail($request->role_id);
            $user->assignRole($role);
            Log::info('Rôle attribué avec succès', ['role' => $role->name]);

            $passwordTemp = 'CLEAN';

            $data = [
                'username' => $request->username,
                'email' => $request->email,
                'password' => $passwordTemp,
                'nom' => $request->lastname,
                'prenoms' => $request->firstname,
                'telephone' => $request->telephone,
                'genre' => $request->genre,
                'date_naissance' => $dateNaissance,
                'adresse' => $request->adresse,
                'ville_de_residence' => $request->ville_de_residence,
                'code_postal' => $request->code_postal,
                'nationalite' => $request->nationalite,
                'a_propos' => $request->a_propos,
                'role' => $role->name,
            ];

            $email_user = $request->email;

            // SendUserWelcomeEmailJob::dispatch($email_user, $data);

            DB::commit();

            return response()->json([
                'message' => 'L\'utilisateur a été créé avec succès',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.users')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur création utilisateur', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'utilisateur: ' . $e->getMessage()
            ], 500);
        }
    }

    // Fonction pour le modal edit
    public function EditUsers($usersId)
    {
        // Récupérer l'utilisateur et ses relations
        $user = User::findOrFail($usersId);
        $personnel = Personnel::where('id', $user->personnel_id)->first();

        $role = Role::where('id', $user->role_id)->first();

        // Récupérer les listes pour les selects
        $roles = Role::orderBy('name')->get();

        // Formater la date de naissance si elle existe
        if ($personnel && $personnel->date_naissance) {
            $personnel->date_naissance = Carbon::parse($personnel->date_naissance)->format('d-m-Y');
        }

        return response()->json([
            'user' => $user,
            'personnel' => $personnel,
            'role' => $role,
            'roles' => $roles,
        ]);
    }

    // Fonction pour modifier un utilisateur
    public function UpdateUsers(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$request->my_user_id,
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'code_postal' => 'nullable|string|max:6',
            'date_naissance' => 'nullable|date|date_format:d-m-Y',
            'genre' => 'required|string|in:Homme,Femme',
            'nationalite' => 'required|string|max:255',
            'ville_de_residence' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'a_propos' => 'nullable|string|max:1000',
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $personnel = Personnel::findOrFail($request->my_personnel_id);

            $dateNaissance = $request->filled('date_naissance')
                ? Carbon::createFromFormat('d-m-Y', $request->date_naissance)->format('Y-m-d')
                : null;

            $personnelData = [
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'date_naissance' => $dateNaissance,
                'genre' => $request->genre,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'ville_de_residence' => $request->ville_de_residence,
                'code_postal' => $request->code_postal,
                'nationalite' => $request->nationalite,
                'a_propos' => $request->a_propos,
                'updated_at' => Carbon::now(),
            ];

            // ✅ Gestion photo de profil avec Storage
            if ($request->hasFile('photo_profil')) {

                // ✅ Suppression de l’ancienne image si existe
                if (!empty($personnel->photo_profil)) {
                    $oldImagePath = 'public/upload/user_images/' . $personnel->photo_profil;
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }

                // ✅ Ajout de la nouvelle image
                $image = $request->file('photo_profil');
                $fileName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                
                // Stockage dans storage/app/public/upload/user_images/
                $image->storeAs('public/upload/user_images', $fileName);

                $personnelData['photo_profil'] = $fileName;
            }

            // ✅ Update DB
            Personnel::where('id', $request->my_personnel_id)->update($personnelData);

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            User::where('id', $request->my_user_id)->update($userData);

            $user = User::findOrFail($request->my_user_id);
            $role = Role::findOrFail($request->role_id);
            $user->syncRoles($role);

            DB::commit();

            return response()->json([
                'message' => 'Utilisateur mis à jour avec succès ✅',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.users')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur lors de la mise à jour: '.$e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }
    }

    // Fonction pour supprimer utilisateur
    public function DeleteUsers($userId)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($userId);
            $personnel = Personnel::findOrFail($user->personnel_id);

            // Vérification si l'utilisateur est utilisé
            if ($user->used == 1) {
                return response()->json([
                    'alert-type' => 'warning',
                    'message' => "Impossible de supprimer cet utilisateur car il est actuellement utilisé dans le système.",
                ], 400);
            }

            // Suppression image si existe avec Storage
            if ($personnel->photo_profil) {
                $imagePath = 'public/upload/user_images/' . $personnel->photo_profil;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }

            // Supprimer d'abord l'utilisateur pour éviter FK problèmes (si cascade non configurée)
            $user->delete();
            $personnel->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "L'utilisateur a été supprimé avec succès.",
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Erreur lors de la suppression de l\'utilisateur', [
                'user_id' => $userId,
                'error_message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage(),
            ], 500);
        }
    }

    //Fonction pour désactiver un utilisateur
    public function InactiveUsers($id){
        User::findOrFail($id)->update(['status' => 0]);

        return response()->json([
            'message' => 'L\'utilisateur est désactivé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.users'),
        ]);
    }

    // Fonction pour activer un utilisateur
    public function ActiveUsers($id){
        User::findOrFail($id)->update(['status' => 1]);

        return response()->json([
            'message' => 'L\'utilisateur est activé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.users'),
        ]);
    }

    public function CheckEmailUsers(Request $request){
        $count = User::where('email', $request->email)->count();
        return response()->json(['exists' => $count > 0]);
    }

    public function showUsers($userId)
    {
        try {
            Log::info('Début de récupération des informations de l\'utilisateur.', ['userId' => $userId]);

            // Charger toutes les relations nécessaires
            $user = User::with([
                'role',
            ])->find($userId);

            if (!$user) {
                Log::error('Utilisateur non trouvé', ['user_id' => $userId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ], 404);
            }

            // Récupérer les informations du personnel associé
            $personnel = Personnel::where('id', $user->personnel_id)->first();

            if (!$personnel) {
                Log::error('Informations personnel non trouvées', ['user_id' => $userId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Informations personnel non trouvées'
                ], 404);
            }

            // Formater la date de naissance si elle existe
            if ($personnel->date_naissance) {
                $personnel->date_naissance = Carbon::parse($personnel->date_naissance)->format('d-m-Y');
            }

            // Récupérer l'URL de la photo de profil avec Storage
            $photoUrl = null;
            if ($personnel->photo_profil) {
                // Vérifier si l'image existe dans le storage
                if (Storage::exists('public/upload/user_images/' . $personnel->photo_profil)) {
                    $photoUrl = Storage::url('public/upload/user_images/' . $personnel->photo_profil);
                } else {
                    // Image par défaut si le fichier n'existe pas
                    $photoUrl = asset('upload/no_image.jpg');
                }
            } else {
                // Image par défaut si pas de photo
                $photoUrl = asset('upload/no_image.jpg');
            }

            // Préparer les données de réponse
            $responseData = [
                'user' => $user,
                'personnel' => array_merge($personnel->toArray(), [
                    'photo_profil_url' => $photoUrl
                ])
            ];

            Log::info('Informations utilisateur récupérées avec succès');

            return response()->json([
                'success' => true,
                'data' => $responseData
            ]);

        } catch (\Exception $e) {
            Log::error('Exception dans showUser', [
                'user_id' => $userId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails : ' . $e->getMessage()
            ], 500);
        }
    }

    // Fonction pour activer le rôle de l'utilisateur
    public function activateRole(Request $request, $id)
    {
        try {
            // Validation de la requête
            $request->validate([
                'role_id' => 'required|exists:roles,id',
                'chefService' => 'nullable|boolean',
            ], [
                'role_id.required' => 'Le rôle est obligatoire',
                'role_id.exists' => 'Le rôle sélectionné n\'existe pas',
            ]);

            // Récupération de l'utilisateur
            $user = User::findOrFail($id);

            // Récupération du rôle
            $role = Role::findOrFail($request->role_id);

            DB::beginTransaction();

            try {
                // Mise à jour du rôle et du statut de l'utilisateur
                $user->update([
                    'status' => 1,
                    'role_id' => $request->role_id,
                    'chef_service' => $request->has('chefService') ? (bool) $request->chefService : false,
                ]);

                // Supprime tous les anciens rôles et assigne le nouveau
                $user->syncRoles([$role->name]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'L\'utilisateur a été activé avec succès',
                    'redirect_url' => route('all.users')
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'activation de l'utilisateur", [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'activation de l\'utilisateur: ' . $e->getMessage()
            ], 500);
        }
    }
}