<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    //

    public function AllCategory() {
        $categories = Category::latest()->get();
        return view('backend.category.category_all', compact('categories'));
    }

    // Fonction pour ajouter un categorie
    public function StoreCategory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group-a' => 'required|array|min:1',
                'group-a.*.nom' => 'required|string|max:255',
                'group-a.*.description' => 'required|string',
            ], [
                'group-a.required' => 'Veuillez ajouter au moins un categorie',
                'group-a.array' => 'Format de données invalide',
                'group-a.min' => 'Veuillez ajouter au moins un categorie',
                'group-a.*.nom.required' => 'Le nom du categorie est obligatoire',
                'group-a.*.nom.string' => 'Le nom doit être une chaîne de caractères',
                'group-a.*.nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
                'group-a.*.description.required' => 'La description est obligatoire',
                'group-a.*.description.string' => 'La description doit être une chaîne de caractères'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $categories = $request->input('group-a');

            foreach ($categories as $categoryData) {
                // Générer le slug à partir du nom
                $slug = \Str::slug($categoryData['nom']);
                
                // Vérifier si le slug existe déjà et le rendre unique si nécessaire
                $count = Category::where('slug', 'like', $slug . '%')->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                
                Category::create([
                    'name' => $categoryData['nom'],
                    'slug' => $slug,
                    'description' => $categoryData['description'],
                    'status' => 1, // Actif par défaut
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Les catégories ont été créées avec succès.',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.category'),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur StoreCategory: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout des types de dossiers: ' . $e->getMessage()
            ], 500);
        }
    }

    //Fonction pour le modal edit
    public function EditCategory($categoryId)
    {
        // Récupérer le rôle avec ses permissions associées
        $category = Category::findOrFail($categoryId);

        return response()->json([
            'category' => $category,
        ]);
    }

    // Fonction pour ,odifier un categorie
    public function UpdateCategory(Request $request)
    {
        try {
            // Validation des données
            // Log::info('Début de la méthode UpdateCategory', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'nom' => 'required|string|max:255',
                'description' => 'required|string',
            ], [
                'category_id.required' => 'L\'identifiant du categorie est manquant',
                'category_id.exists' => 'Le categorie n\'existe pas',
                'nom.required' => 'Le nom du categorie est obligatoire.',
                'nom.string' => 'Le nom doit être une chaîne de caractères',
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
                'description.required' => 'La description est obligatoire.',
                'description.string' => 'La description doit être une chaîne de caractères',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            Log::info('Début de la transaction pour la mise à jour du categorie.');

            $category_id = $request->input('category_id');
            Log::info('ID du categorie reçu', ['category_id' => $category_id]);

            // Récupérer le categorie
            $category = Category::findOrFail($category_id);
            Log::info('categorie trouvé', ['category' => $category]);

            // Vérifier si le nom a changé pour mettre à jour le slug
            $data = [
                'name' => $request->nom,
                'description' => $request->description,
                'updated_at' => Carbon::now(),
            ];

            // Si le nom a changé, mettre à jour le slug
            if ($category->name !== $request->nom) {
                $slug = \Str::slug($request->nom);
                
                // Vérifier si le nouveau slug existe déjà pour un autre enregistrement
                $existingCategory = Category::where('slug', $slug)
                    ->where('id', '!=', $category_id)
                    ->first();
                    
                if ($existingCategory) {
                    $count = Category::where('slug', 'like', $slug . '%')
                        ->where('id', '!=', $category_id)
                        ->count();
                    $slug = $slug . '-' . ($count + 1);
                }
                
                $data['slug'] = $slug;
            }

            // Mettre à jour le categorie
            $category->update($data);
            Log::info('categorie mis à jour avec succès', ['data' => $category]);

            DB::commit();
            Log::info('Transaction terminée avec succès.');

            return response()->json([
                'success' => true,
                'message' => 'Le categorie a été modifié avec succès.',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.category'),
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de la mise à jour du categorie', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du categorie: ' . $e->getMessage()
            ], 500);
        }
    }

    //Fonction pour supprimer un categorie
    public function DeleteCategory($roleId)
    {
        try {

            $Category = Category::findOrFail($roleId);

            if ($Category->used == 1) {
                $nombrecategories = DB::table('dossiers')
                    ->where('category_id', $roleId)
                    ->count();

                $message = $nombrecategories > 0
                    ? "Impossible de supprimer ce categorie car il est actuellement assigné à {$nombrecategories} dossier(s)."
                    : "Impossible de supprimer ce categorie car il est actuellement utilisé dans le système.";

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }


            if ($Category->used == 1) {
                $nombrecategories = DB::table('workflows')
                    ->where('category_id', $roleId)
                    ->count();

                $message = $nombrecategories > 0
                    ? "Impossible de supprimer ce categorie car il est actuellement assigné à {$nombrecategories} workflow(s)."
                    : "Impossible de supprimer ce categorie car il est actuellement utilisé dans le système.";

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }

            $Category->delete();

            return response()->json([
                'success' => true,
                'alert-type' => 'Succès',
                'message' => 'Le categorie est supprimé avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du categorie : ' . $e->getMessage(),
            ], 500);
        }
    }

    //Fonction pour afficher les types de dossier
    public function ShowCategory($CategoryId)
    {
        try {
            Log::info('Début de récupération des informations du dossier.', ['CategoryId' => $CategoryId]);

            // Log de vérification si l'ID existe
            $category = Category::find($CategoryId);
            if (!$category) {
                Log::error('categorie non trouvé', ['category_id' => $CategoryId]);
                return response()->json([
                    'success' => false,
                    'message' => 'categorie non trouvé'
                ], 404);
            }

            Log::info('categorie trouvé', ['Dossier' => $category->toArray()]);

            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            Log::error('Exception dans ShowDossier', [
                'category_id' => $CategoryId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails : ' . $e->getMessage()
            ], 500);
        }
    }

    // Fonction pour activer un categorie
    public function ActiveCategory($id){
        Category::findOrFail($id)->update(['status' => 1]);

        return response()->json([
            'message' => 'Le categorie est activé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.category'),
        ]);
    }// end method

    // Fonction pour désactiver un categorie
    public function InactiveCategory($id){
        Category::findOrFail($id)->update(['status' => 0]);

        return response()->json([
            'message' => 'Le categorie est désactivé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.category'),
        ]);
    }// end method



}
