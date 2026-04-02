<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{

    public function index()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('admin.dashboardVendors');
    }

    
    public function register() {

        return view('auth.register');
    }

    public function login(){

        return view('auth.login');
    }

    public function ViewParametre() {

        // $users = Auth::user()->first();
        $users = Auth::user();
        $personnel = Personnel::where('id', $users->personnel_id)->first();
        $personnel->date_naissance = Carbon::parse($personnel->date_naissance)->format('d-m-Y');

        // dd($personnel->getFirstMediaUrl('photo_profil'));

        return view('backend.profile.parametre_profile', compact('users', 'personnel'));


    } // End method

    
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'photo_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'photo_profil.required' => 'Veuillez sélectionner une image',
            'photo_profil.mimes' => 'Le format doit être JPEG, PNG, JPG ou GIF',
            'photo_profil.max' => 'La taille de l\'image ne doit pas dépasser 2MB'
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $personnel = Personnel::findOrFail($user->personnel_id);

            if ($request->hasFile('photo_profil')) {

                // Téléchargez et enregistrez le fichier\

                //dd($personnel->photo_profil);

                if ($personnel->photo_profil){
                    unlink('upload/user_images/' .$personnel->photo_profil);
                }

                $image = $request->file('photo_profil');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('upload/user_images/' . $name_gen);
                // Remplacer les barres obliques selon le système d'exploitation
                $imagePath = str_replace(DIRECTORY_SEPARATOR, '/', $imagePath);


                // Enregistrez l'image avec Intervention Image
                
                $manager = new ImageManager(new Driver());
                $manager->read($image)->save($imagePath);

                // Mettez à jour le champ d'image de profil de l'utilisateur dans la base de données
                $personnel->photo_profil = $name_gen;
                $personnel->save();

                DB::commit(); // ✅ On valide la transaction

                
                return response()->json([
                    'message' => 'Photo de profil en cours de traitement...',
                    'alert-type' => 'succès',
                    'personnel_id' => $personnel->id,
                    'redirect_url' => route('parametre'),
                    'check_status' => true
                ]);


            } else {
                Log::warning('Aucun fichier photo_profil dans la requête');
                throw new \Exception('Aucune image n\'a été fournie');
            }

            throw new \Exception('Aucune image n\'a été fournie');
        } catch (\Exception $e) {
            Log::error('Erreur de mise à jour de photo', [
                'message' => $e->getMessage(),
                'ligne' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage(),
                'alert-type' => 'error',
                'redirect_url' => route('parametre')
            ], 500);
        }
    }

    
    public function checkProfilePhotoStatus(Request $request)
    {
        try {
            $personnel_id = $request->personnel_id;
            $personnel = Personnel::findOrFail($personnel_id);

            // Vérifier si une photo de profil existe (non null)
            $isProcessed = !is_null($personnel->photo_profil);
            
            // Construire l'URL de l'image si elle existe
            $imageUrl = null;
            if ($isProcessed) {
                $imageUrl = asset('upload/user_images/' . $personnel->photo_profil);
            }

            return response()->json([
                'processed' => $isProcessed,
                'redirect_url' => route('parametre'),
                'image_url' => $imageUrl,
                'message' => 'Photo de profil mise à jour avec succès',
                'alert-type' => 'succès',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la vérification du statut de la photo', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'processed' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function UserProfileStore(Request $request) {

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
            'a_propos' => 'nullable|string|max:1000',
        ], [
            // Validations pour les informations de connexion
            'name.required' => 'Le nom d\'utilisateur est obligatoire',
            'name.string' => 'Le nom d\'utilisateur doit être une chaîne de caractères',
            'name.max' => 'Le nom d\'utilisateur ne doit pas dépasser 255 caractères',

            'email.required' => 'L\'adresse email est obligatoire',
            'email.email' => 'L\'adresse email doit être valide',
            'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères',
            'email.unique' => 'Cette adresse email est déjà utilisée',

            /*'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',*/

            // Validations pour les informations personnelles
            'nom.required' => 'Le nom est obligatoire',
            'nom.string' => 'Le nom doit être une chaîne de caractères',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',

            'prenoms.required' => 'Le(s) prénom(s) est/sont obligatoire(s)',
            'prenoms.string' => 'Le(s) prénom(s) doit/doivent être une chaîne de caractères',
            'prenoms.max' => 'Le(s) prénom(s) ne doit/doivent pas dépasser 255 caractères',

            'telephone.required' => 'Le numéro de téléphone est obligatoire',
            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères',
            'telephone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères',

            'code_postal.max' => 'Le code postal ne doit pas dépasser 6 caractères',

            // 'date_naissance.date' => 'La date de naissance doit être une date valide',
            // 'date_naissance.required' => 'La date de naissance est obligatoire',

            'genre.in' => 'Le genre doit être soit Homme soit Femme',
            'genre.required' => 'Le genre doit est obligatoire',

            'nationalite.max' => 'La nationalité ne doit pas dépasser 255 caractères',
            'nationalite.required' => 'La nationalité est obligatoire',

            'ville_de_residence.max' => 'La ville de résidence ne doit pas dépasser 255 caractères',
            'ville_de_residence.required' => 'La ville de résidence est obligatire',

            'adresse.max' => 'L\'adresse ne doit pas dépasser 255 caractères',
            'adresse.required' => 'L\'adresse est obligatoire',

            'a_propos.max' => 'La biographie ne doit pas dépasser 1000 caractères'
        ]);

        try {

            DB::beginTransaction();

            // Mise à jour du personnel
            Personnel::where('id', $request->my_personnel_id)->update([
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'date_naissance' => Carbon::createFromFormat('d-m-Y', $request->date_naissance)->format('Y-m-d'),
                'genre' => $request->genre,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'ville_de_residence' => $request->ville_de_residence,
                'code_postal' => $request->code_postal,
                'nationalite' => $request->nationalite,
                //'photo_profil' => $request->file('photo_profil') ? $photo_profil : null,
                'a_propos' => $request->a_propos,
                'updated_at' => Carbon::now(),
            ]);

            // Mise à jour de l'utilisateur
            User::where('id', $request->my_user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => Carbon::now(),
                /* 'poste_id' => $request->poste_id,
                 'service_id' => $request->service_id,
                 'role_id' => $request->role_id,*/
            ]);


            /*   // Si un nouveau mot de passe est fourni
               if ($request->filled('password')) {
                   User::where('id', $request->user_id)->update([
                       'password' => Hash::make($request->password)
                   ]);
               }*/

            DB::commit();

            return response()->json([
                'message' => 'Utilisateur mis à jour avec succès',
                'alert-type' => 'Succès',
                'redirect_url' => route('parametre')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage(),
                'alert-type' => 'error'
            ], 500);
        }

    }



    public function DeleteProfileImage()
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $personnel = Personnel::findOrFail($user->personnel_id);

            if ($personnel->photo_profil) {
                $imagePath = public_path('upload/user_images/' . $personnel->photo_profil);

                // Vérifier si le fichier existe avant suppression
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                $personnel->photo_profil = null;
                $personnel->save();
            }

            DB::commit(); // ✅ On valide la transaction

            return response()->json([
                'success' => true,
                'message' => 'Image de profil supprimée avec succès',
                'alert-type' => 'Succès',
                'redirect_url' => route('parametre')
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Erreur lors de la suppression de l\'image de profil', [
                'user_id' => $user->id ?? 'N/A',
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage(),
                'alert-type' => 'error',
                'redirect_url' => route('parametre')
            ], 500);
        }
    }


    public function GetPassword() {

        $users = Auth::user()->first();
        $personnel = Personnel::where('id', $users->personnel_id)->first();

        return view('backend.profile.password_profile', compact('users', 'personnel'));
    } // end method


    public function UpdatePassword(Request $request){

        // Valider les données de la requête
        $request->validate([
            'old_password' => [
                'required',
                'string',
                'max:255',
                // Custom rule to check if old password matches
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('L\'ancien mot de passe est incorrect.');
                    }
                }
            ],
            // 'new_password' => 'required|string|min:8|confirmed',
            // 'new_password_confirmation' => 'required|string|max:255',


            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&()_+\[\]{}|;:,.<>?])[A-Za-z\d@#$%^&()_+\[\]{}|;:,.<>?]{8,}$/',
            ],
            'new_password_confirmation' => 'required|same:new_password',

        ], [
            // Validations pour le mot de passe actuel
            'old_password.required' => 'L\'ancien mot de passe est obligatoire',
            'old_password.string' => 'L\'ancien mot de passe doit être une chaîne de caractères',
            'old_password.max' => 'L\'ancien mot de passe ne doit pas dépasser 255 caractères',

            // // Validations pour le nouveau mot de passe
            // 'new_password.required' => 'Le nouveau mot de passe est obligatoire',
            // 'new_password.string' => 'Le nouveau mot de passe doit être une chaîne de caractères',
            // 'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères',
            // 'new_password.confirmed' => 'La confirmation du nouveau mot de passe ne correspond pas',

            // // Validations pour la confirmation du nouveau mot de passe
            // 'new_password_confirmation.required' => 'La confirmation du nouveau mot de passe est obligatoire',
            // 'new_password_confirmation.string' => 'La confirmation du mot de passe doit être une chaîne de caractères',
            // 'new_password_confirmation.max' => 'La confirmation du mot de passe ne doit pas dépasser 255 caractères',




            'new_password.required' => 'Le mot de passe est obligatoire',
            'new_password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'new_password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial',
            'new_password_confirmation.required' => 'La confirmation du mot de passe est obligatoire',
            'new_password_confirmation.same' => 'La confirmation du mot de passe ne correspond pas',
        ]);


        // Récupérer l'utilisateur actuel
        $users = Auth::user()->first();
        //$personnel = Personnel::where('id', $users->personnel_id)->first();

        // Vérifier si l'ancien mot de passe est correct
        if (!Hash::check($request->old_password, $users->password)) {

            return response()->json([
                'message' => 'Le mot de passe actuel est incorrect.',
                'alert-type' => 'Succès',
                'redirect_url' => route('get.password')
            ]);
        }

        // Mettre à jour le mot de passe
        $users->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Rediriger avec un message de succès
        return response()->json([
            'message' => 'Votre mot de passe a été modifié avec succès',
            'alert-type' => 'Succès',
            'redirect_url' => route('get.password')
        ]);

    }


    public function logout(Request $request)
    {
        // Log de déconnexion
        Log::info('Déconnexion utilisateur', [
            'user_id' => Auth::id(),
            'email' => Auth::user()->email ?? 'inconnu',
            'ip' => $request->ip()
        ]);

        // Déconnexion
        Auth::logout();
        
        // Invalider la session
        $request->session()->invalidate();
        
        // Régénérer le token CSRF
        $request->session()->regenerateToken();
        
        // Redirection selon le referer ou par défaut
        if (str_contains($request->headers->get('referer'), '/client')) {
            return redirect()->route('client.index')
                ->with('success', 'Vous avez été déconnecté avec succès.');
        }
        
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
