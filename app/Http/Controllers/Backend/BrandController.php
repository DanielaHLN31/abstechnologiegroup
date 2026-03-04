<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brand;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    //

    public function AllBrand() {
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_all', compact('brands'));
    }

    // Fonction pour ajouter un brand
    public function StoreBrand(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group-a' => 'required|array|min:1',
                'group-a.*.nom' => 'required|string|max:255',
            ], [
                'group-a.required' => 'Veuillez ajouter au moins un brand',
                'group-a.array' => 'Format de données invalide',
                'group-a.min' => 'Veuillez ajouter au moins un brand',
                'group-a.*.nom.required' => 'Le nom du brand est obligatoire',
                'group-a.*.nom.string' => 'Le nom doit être une chaîne de caractères',
                'group-a.*.nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $brands = $request->input('group-a');

            foreach ($brands as $brandData) {
                // Générer le slug à partir du nom
                $slug = \Str::slug($brandData['nom']);
                
                // Vérifier si le slug existe déjà et le rendre unique si nécessaire
                $count = Brand::where('slug', 'like', $slug . '%')->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                
                Brand::create([
                    'name' => $brandData['nom'],
                    'slug' => $slug,
                    'status' => 1, // Actif par défaut
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Les catégories ont été créées avec succès.',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.brand'),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur Storebrand: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout des marques: ' . $e->getMessage()
            ], 500);
        }
    }

    //Fonction pour le modal edit
    public function EditBrand($brandId)
    {
        // Récupérer le rôle avec ses permissions associées
        $brand = Brand::findOrFail($brandId);

        return response()->json([
            'brand' => $brand,
        ]);
    }

    // Fonction pour ,odifier un brand
    public function UpdateBrand(Request $request)
    {
        try {
            // Validation des données
            // Log::info('Début de la méthode Updatebrand', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'brand_id' => 'required|exists:brands,id',
                'nom' => 'required|string|max:255',
            ], [
                'brand_id.required' => 'L\'identifiant du brand est manquant',
                'brand_id.exists' => 'Le brand n\'existe pas',
                'nom.required' => 'Le nom du brand est obligatoire.',
                'nom.string' => 'Le nom doit être une chaîne de caractères',
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            Log::info('Début de la transaction pour la mise à jour du brand.');

            $brand_id = $request->input('brand_id');
            Log::info('ID du brand reçu', ['brand_id' => $brand_id]);

            // Récupérer le brand
            $brand = Brand::findOrFail($brand_id);
            Log::info('brand trouvé', ['brand' => $brand]);

            // Vérifier si le nom a changé pour mettre à jour le slug
            $data = [
                'name' => $request->nom,
                'updated_at' => Carbon::now(),
            ];

            // Si le nom a changé, mettre à jour le slug
            if ($brand->name !== $request->nom) {
                $slug = \Str::slug($request->nom);
                
                // Vérifier si le nouveau slug existe déjà pour un autre enregistrement
                $existingbrand = Brand::where('slug', $slug)
                    ->where('id', '!=', $brand_id)
                    ->first();
                    
                if ($existingbrand) {
                    $count = Brand::where('slug', 'like', $slug . '%')
                        ->where('id', '!=', $brand_id)
                        ->count();
                    $slug = $slug . '-' . ($count + 1);
                }
                
                $data['slug'] = $slug;
            }

            // Mettre à jour le brand
            $brand->update($data);
            Log::info('brand mis à jour avec succès', ['data' => $brand]);

            DB::commit();
            Log::info('Transaction terminée avec succès.');

            return response()->json([
                'success' => true,
                'message' => 'La marque a été modifié avec succès.',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.brand'),
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Erreur lors de la mise à jour de la  marque', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la marque: ' . $e->getMessage()
            ], 500);
        }
    }

    //Fonction pour supprimer un brand
    public function DeleteBrand($roleId)
    {
        try {

            $brand = Brand::findOrFail($roleId);

            if ($brand->used == 1) {
                $nombrebrands = DB::table('dossiers')
                    ->where('brand_id', $roleId)
                    ->count();

                $message = $nombrebrands > 0
                    ? "Impossible de supprimer ce brand car il est actuellement assigné à {$nombrebrands} dossier(s)."
                    : "Impossible de supprimer ce brand car il est actuellement utilisé dans le système.";

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }


            if ($brand->used == 1) {
                $nombrebrands = DB::table('workflows')
                    ->where('brand_id', $roleId)
                    ->count();

                $message = $nombrebrands > 0
                    ? "Impossible de supprimer ce brand car il est actuellement assigné à {$nombrebrands} workflow(s)."
                    : "Impossible de supprimer ce brand car il est actuellement utilisé dans le système.";

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }

            $brand->delete();

            return response()->json([
                'success' => true,
                'alert-type' => 'Succès',
                'message' => 'Le brand est supprimé avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du brand : ' . $e->getMessage(),
            ], 500);
        }
    }

    //Fonction pour afficher les marque
    public function ShowBrand($brandId)
    {
        try {
            Log::info('Début de récupération des informations du dossier.', ['brandId' => $brandId]);

            // Log de vérification si l'ID existe
            $brand = Brand::find($brandId);
            if (!$brand) {
                Log::error('brand non trouvé', ['brand_id' => $brandId]);
                return response()->json([
                    'success' => false,
                    'message' => 'brand non trouvé'
                ], 404);
            }

            Log::info('brand trouvé', ['Dossier' => $brand->toArray()]);

            return response()->json([
                'success' => true,
                'brand' => $brand
            ]);
        } catch (\Exception $e) {
            Log::error('Exception dans ShowDossier', [
                'brand_id' => $brandId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails : ' . $e->getMessage()
            ], 500);
        }
    }

    // Fonction pour activer un brand
    public function ActiveBrand($id){
        Brand::findOrFail($id)->update(['status' => 1]);

        return response()->json([
            'message' => 'Le brand est activé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.brand'),
        ]);
    }// end method

    // Fonction pour désactiver un brand
    public function InactiveBrand($id){
        Brand::findOrFail($id)->update(['status' => 0]);

        return response()->json([
            'message' => 'Le brand est désactivé',
            'alert-type' => 'Succès',
            'redirect_url' => route('all.brand'),
        ]);
    }// end method



}
