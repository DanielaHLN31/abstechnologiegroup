<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    //
    public function AllProducts()
    {
        $products = Product::with(['category', 'brand', 'images'])->latest()->get();
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('backend.product.product_all', compact('products', 'categories', 'brands'));
    }

    
    /**
     * Afficher le détail d'un produit
     */public function ShowProduct($id)
    {
        try {
            $product = Product::with(['category', 'brand', 'images', 'colors', 'specifications'])
                            ->findOrFail($id);

            return response()->json([
                'success' => true,
                'product' => $product
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produit non trouvé'
            ], 404);
        }
    }

    // Fonction pour ajouter un product
    public function Storeproducts(Request $request)
    {
        try {
            $input = $request->all();

            // ── Normaliser : réindexer colors et specifications (clés timestamp → 0,1,2...)
            if (!empty($input['group-a']) && is_array($input['group-a'])) {
                foreach ($input['group-a'] as $pIdx => &$productData) {
                    if (!empty($productData['colors']) && is_array($productData['colors'])) {
                        $productData['colors'] = array_values($productData['colors']);
                    }
                    if (!empty($productData['specifications']) && is_array($productData['specifications'])) {
                        $productData['specifications'] = array_values($productData['specifications']);
                    }
                }
                unset($productData);
            }

            // ── Validation ────────────────────────────────────────────────────────
            $validator = Validator::make($input, [
                'group-a'                           => 'required|array|min:1',
                'group-a.*.name'                    => 'required|string|max:255',
                'group-a.*.description'             => 'required|string',
                'group-a.*.price'                   => 'required|numeric|min:0',
                'group-a.*.compare_price'           => 'nullable|numeric|min:0',
                'group-a.*.brand_id'                => 'required|exists:brands,id',
                'group-a.*.category_id'             => 'required|exists:categories,id',
                'group-a.*.stock_quantity'          => 'nullable|integer|min:0',
                'group-a.*.low_stock_threshold'     => 'nullable|integer|min:0',
                'group-a.*.status'                  => 'nullable|in:draft,published,archived',
                'group-a.*.is_featured'             => 'nullable|boolean',
                'group-a.*.meta_title'              => 'nullable|string|max:255',
                'group-a.*.meta_description'        => 'nullable|string',
                'group-a.*.colors'                  => 'nullable|array',
                'group-a.*.colors.*.id'             => 'nullable|exists:colors,id',
                'group-a.*.colors.*.name'           => 'nullable|string|max:100',
                'group-a.*.colors.*.code'           => 'nullable|string|max:20',
                'group-a.*.colors.*.stock_quantity' => 'nullable|integer|min:0',
                'group-a.*.specifications'          => 'nullable|array',
                'group-a.*.specifications.*.name'   => 'nullable|string|max:100',
                'group-a.*.specifications.*.value'  => 'nullable|string|max:255',
            ], [
                'group-a.required'               => 'Veuillez ajouter au moins un produit.',
                'group-a.*.name.required'        => 'Le nom du produit est obligatoire.',
                'group-a.*.description.required' => 'La description est obligatoire.',
                'group-a.*.price.required'       => 'Le prix est obligatoire.',
                'group-a.*.brand_id.required'    => 'La marque est obligatoire.',
                'group-a.*.category_id.required' => 'La catégorie est obligatoire.',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // ── Validation des images (séparée car fichiers) ─────────────────────
            $allFiles    = $request->file('group-a') ?? [];
            $imageErrors = [];

            foreach ($input['group-a'] as $pIdx => $productData) {
                $images = $allFiles[$pIdx]['images'] ?? null;

                if (empty($images) || !is_array($images)) {
                    $imageErrors["group-a.{$pIdx}.images"] = ['Veuillez ajouter au moins une image.'];
                    continue;
                }
                foreach ($images as $iIdx => $image) {
                    if (!$image || !$image->isValid()) {
                        $imageErrors["group-a.{$pIdx}.images.{$iIdx}"] = ['Fichier image invalide.'];
                        continue;
                    }
                    if (!in_array(strtolower($image->getClientOriginalExtension()), ['jpg','jpeg','png','gif','webp'])) {
                        $imageErrors["group-a.{$pIdx}.images.{$iIdx}"] = ['Format accepté : jpeg, png, jpg, gif, webp.'];
                    }
                    if ($image->getSize() > 2048 * 1024) {
                        $imageErrors["group-a.{$pIdx}.images.{$iIdx}"] = ["L'image ne doit pas dépasser 2 Mo."];
                    }
                }
            }

            if (!empty($imageErrors)) {
                return response()->json(['errors' => $imageErrors], 422);
            }

            DB::beginTransaction();

            foreach ($input['group-a'] as $pIdx => $productData) {

                // ── Stock calculé depuis les couleurs ────────────────────────────
                $colorsStockTotal = 0;
                $hasColorStock    = false;
                if (!empty($productData['colors'])) {
                    foreach ($productData['colors'] as $c) {
                        $qty = (int) ($c['stock_quantity'] ?? 0);
                        if ($qty > 0) { $colorsStockTotal += $qty; $hasColorStock = true; }
                    }
                }
                $finalStock = $hasColorStock ? $colorsStockTotal : (int) ($productData['stock_quantity'] ?? 0);

                // ── Création du produit ──────────────────────────────────────────
                $product = Product::create([
                    'name'                => $productData['name'],
                    'description'         => $productData['description'],
                    'price'               => $productData['price'],
                    'compare_price'       => $productData['compare_price'] ?? null,
                    'brand_id'            => $productData['brand_id'],
                    'category_id'         => $productData['category_id'],
                    'stock_quantity'      => $finalStock,
                    'in_stock'            => $finalStock > 0,
                    'low_stock_threshold' => $productData['low_stock_threshold'] ?? 5,
                    'status'              => $productData['status'] ?? 'draft',
                    'is_featured'         => !empty($productData['is_featured']),
                    'meta_title'          => $productData['meta_title'] ?? null,
                    'meta_description'    => $productData['meta_description'] ?? null,
                ]);

                // ── Images ───────────────────────────────────────────────────────
                foreach ($allFiles[$pIdx]['images'] ?? [] as $sortOrder => $image) {
                    if (!$image || !$image->isValid()) continue;
                    $ext  = $image->getClientOriginalExtension();
                    $name = time() . '_' . $product->id . '_' . $sortOrder . '.' . $ext;
                    $path = $image->storeAs('products/' . $product->id, $name, 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'sort_order' => $sortOrder,
                        'is_primary' => $sortOrder === 0,
                    ]);
                }

                // ── Couleurs ─────────────────────────────────────────────────────
                if (!empty($productData['colors'])) {
                    $syncData = [];
                    foreach ($productData['colors'] as $colorData) {
                        $existingId = $colorData['id'] ?? null;
                        if (!empty($existingId)) {
                            $syncData[$existingId] = ['stock_quantity' => (int) ($colorData['stock_quantity'] ?? 0)];
                        } elseif (!empty($colorData['name'])) {
                            $color = Color::firstOrCreate(
                                ['name' => $colorData['name']],
                                ['code' => $colorData['code'] ?? null]
                            );
                            $syncData[$color->id] = ['stock_quantity' => (int) ($colorData['stock_quantity'] ?? 0)];
                        }
                    }
                    if (!empty($syncData)) $product->colors()->sync($syncData);
                }

                // ── Spécifications ───────────────────────────────────────────────
                if (!empty($productData['specifications'])) {
                    $order = 0;
                    foreach ($productData['specifications'] as $spec) {
                        if (!empty($spec['name'])) {
                            $product->specifications()->create([
                                'name'       => $spec['name'],
                                'value'      => $spec['value'] ?? '',
                                'is_badge'   => !empty($spec['is_badge']),
                                'sort_order' => $order++,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Les produits ont été créés avec succès.',
                'alert-type'   => 'Succès',
                'redirect_url' => route('all.products'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur Storeproducts: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }

    
    public function EditProducts($id)
    {
        $product = Product::with([
            'images',
            'colors',          // BelongsToMany → inclut pivot (stock_quantity)
            'specifications',
        ])->findOrFail($id);

        return response()->json(['product' => $product]);
    }


    public function UpdateProductS(Request $request)
    {
        try {
            $product = Product::findOrFail($request->input('product_id'));

            // ── Validation ────────────────────────────────────────────
            $validated = $request->validate([
                'name'                          => 'required|string|max:255',
                'description'                   => 'required|string',
                'price'                         => 'required|numeric|min:0',
                'compare_price'                 => 'nullable|numeric|min:0',
                'category_id'                   => 'required|exists:categories,id',
                'brand_id'                      => 'required|exists:brands,id',
                'stock_quantity'                => 'nullable|integer|min:0',
                'low_stock_threshold'           => 'nullable|integer|min:0',
                'status'                        => 'nullable|in:draft,published,archived',
                'is_featured'                   => 'nullable',
                'meta_title'                    => 'nullable|string|max:255',
                'meta_description'              => 'nullable|string',
                'new_images.*'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'existing_images'               => 'nullable|array',
                'existing_images.*'             => 'integer',
                'colors'                        => 'nullable|array',
                'colors.*.id'                   => 'nullable|exists:colors,id',
                'colors.*.name'                 => 'nullable|string|max:100',
                'colors.*.code'                 => 'nullable|string|max:20',
                'colors.*.stock_quantity'       => 'nullable|integer|min:0',
                'specifications'                => 'nullable|array',
                'specifications.*.db_id'        => 'nullable|integer',
                'specifications.*.name'         => 'nullable|string|max:100',
                'specifications.*.value'        => 'nullable|string|max:255',
            ], [
                'name.required'        => 'Le nom du produit est obligatoire.',
                'description.required' => 'La description est obligatoire.',
                'price.required'       => 'Le prix est obligatoire.',
                'category_id.required' => 'La catégorie est obligatoire.',
                'brand_id.required'    => 'La marque est obligatoire.',
            ]);

            DB::beginTransaction();

            // ── Calcul stock depuis couleurs ──────────────────────────
            $colorsData       = $request->input('colors', []);
            $colorsStockTotal = 0;
            $hasColorStock    = false;
            foreach ($colorsData as $c) {
                $qty = (int) ($c['stock_quantity'] ?? 0);
                if ($qty > 0) { $colorsStockTotal += $qty; $hasColorStock = true; }
            }
            $finalStock = $hasColorStock
                ? $colorsStockTotal
                : (int) ($validated['stock_quantity'] ?? 0);

            // ── Mise à jour produit ───────────────────────────────────
            $product->update([
                'name'                => $validated['name'],
                'description'         => $validated['description'],
                'price'               => $validated['price'],
                'compare_price'       => $validated['compare_price'] ?? null,
                'category_id'         => $validated['category_id'],
                'brand_id'            => $validated['brand_id'],
                'stock_quantity'      => $finalStock,
                'in_stock'            => $finalStock > 0,
                'low_stock_threshold' => $validated['low_stock_threshold'] ?? 5,
                'status'              => $validated['status'] ?? 'draft',
                'is_featured'         => $request->has('is_featured'),
                'meta_title'          => $validated['meta_title'] ?? null,
                'meta_description'    => $validated['meta_description'] ?? null,
            ]);

            // ── Images : supprimer celles retirées ────────────────────
            // APRÈS — supprime uniquement les images explicitement marquées
            $deletedIds = array_filter(
                array_map('intval', $request->input('deleted_images', []))
            );

            if (!empty($deletedIds)) {
                $imagesToDelete = $product->images()->whereIn('id', $deletedIds)->get();
                foreach ($imagesToDelete as $img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }

            // ── Images : ajouter les nouvelles ────────────────────────
            if ($request->hasFile('new_images')) {
                $maxOrder = $product->images()->max('sort_order') ?? -1;
                foreach ($request->file('new_images') as $image) {
                    if (!$image || !$image->isValid()) continue;
                    $maxOrder++;
                    $ext  = $image->getClientOriginalExtension();
                    $name = time() . '_' . $product->id . '_' . $maxOrder . '.' . $ext;
                    $path = $image->storeAs('products/' . $product->id, $name, 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'sort_order' => $maxOrder,
                        'is_primary' => $product->images()->count() === 0,
                    ]);
                }
            }

            // Garantir une image principale
            if ($product->images()->where('is_primary', true)->count() === 0) {
                optional($product->images()->orderBy('sort_order')->first())->update(['is_primary' => true]);
            }

            // ── Couleurs : sync ───────────────────────────────────────
            if (!empty($colorsData)) {
                $syncData = [];
                foreach ($colorsData as $colorData) {
                    $existingId = $colorData['id'] ?? null;
                    if (!empty($existingId)) {
                        $syncData[$existingId] = ['stock_quantity' => (int) ($colorData['stock_quantity'] ?? 0)];
                    } elseif (!empty($colorData['name'])) {
                        $color = Color::firstOrCreate(
                            ['name' => $colorData['name']],
                            ['code' => $colorData['code'] ?? null]
                        );
                        $syncData[$color->id] = ['stock_quantity' => (int) ($colorData['stock_quantity'] ?? 0)];
                    }
                }
                if (!empty($syncData)) {
                    $product->colors()->sync($syncData);
                }
            } else {
                // Aucune couleur → détacher toutes
                $product->colors()->detach();
            }

            // ── Spécifications : supprimer les anciennes, recréer ─────
            // Stratégie : supprimer celles dont l'ID n'est plus présent,
            // créer les nouvelles (sans db_id), mettre à jour les existantes.
            $specsInput   = $request->input('specifications', []);
            $keptSpecIds  = array_filter(array_column($specsInput, 'db_id'));

            // Supprimer les specs retirées
            $product->specifications()->whereNotIn('id', $keptSpecIds)->delete();

            // Créer/mettre à jour
            foreach ($specsInput as $order => $spec) {
                if (empty($spec['name'])) continue;
                $dbId = $spec['db_id'] ?? null;
                if (!empty($dbId)) {
                    // Mise à jour
                    $product->specifications()->where('id', $dbId)->update([
                        'name'       => $spec['name'],
                        'value'      => $spec['value'] ?? '',
                        'sort_order' => $order,
                    ]);
                } else {
                    // Création
                    $product->specifications()->create([
                        'name'       => $spec['name'],
                        'value'      => $spec['value'] ?? '',
                        'is_badge'   => false,
                        'sort_order' => $order,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Produit modifié avec succès.',
                'alert-type' => 'Succès',
                'redirect_url' => route('all.products'),
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur UpdateProduct: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'alert-type' => 'error',
                'message' => 'Erreur lors de la modification : ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Supprimer un produit
     */
    public function DeleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Supprimer les images du disque
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $product->delete(); // soft delete

            return response()->json([
                'success' => true,
                'alert-type' => 'Succès',
                'message' => 'Produit supprimé avec succès.'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur suppression produit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'alert-type' => 'error',
                'message' => 'Impossible de supprimer ce produit.'
            ], 500);
        }
    }


    /**
     * Changer le statut d'un produit (publié ↔ archivé)
     */public function ToggleStatus(Request $request, $id)
    {
        try {
            Log::info('=== DÉBUT ToggleStatus ===');
            Log::info('ID du produit reçu: ' . $id);
            Log::info('Action reçue: ' . $request->input('action'));
            Log::info('Données de la requête:', $request->all());

            $product = Product::findOrFail($id);
            Log::info('Produit trouvé:', [
                'id' => $product->id,
                'nom' => $product->name,
                'statut_actuel' => $product->status
            ]);

            $action = $request->input('action');

            if (!in_array($action, ['publish', 'archive'])) {
                Log::warning('Action invalide reçue: ' . $action);
                return response()->json([
                    'success' => false,
                    'alert-type' => 'error',
                    'message' => 'Action invalide.'
                ], 400);
            }

            $ancienStatut = $product->status;
            $product->status = $action === 'publish' ? 'published' : 'archived';
            $product->save();

            $label = $action === 'publish' ? 'publié' : 'archivé';
            
            Log::info('Statut modifié:', [
                'ancien' => $ancienStatut,
                'nouveau' => $product->status,
                'label' => $label
            ]);

            Log::info('=== FIN ToggleStatus - SUCCÈS ===');

            return response()->json([
                'success' => true,
                'message' => "Produit {$label} avec succès.",
                'status' => $product->status,
                'alert-type' => 'Succès'
            ]);

        } catch (\Exception $e) {
            Log::error('=== ERREUR ToggleStatus ===');
            Log::error('Message: ' . $e->getMessage());
            Log::error('Fichier: ' . $e->getFile() . ' (ligne ' . $e->getLine() . ')');
            Log::error('Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du changement de statut.',
                'alert-type' => 'error',
            ], 500);
        }
    }




}