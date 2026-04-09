<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Support\Facades\Cache;

class ClientController extends Controller
{
    //
    public function index()
    {
        \Log::info('=== DÉBUT DE LA MÉTHODE INDEX ===');
        
        // Récupération des produits normaux
        $products = Product::with(['category', 'brand', 'images'  => fn($q) => $q->where('is_primary', true)->limit(1), 'colors'  => fn($q) => $q->select('colors.id', 'colors.name', 'colors.code'), 'specifications'])
                ->where('status', 'published')
                ->inRandomOrder()
                ->get();
        
        \Log::info('Produits normaux trouvés : ' . $products->count());

        // Articles en vedette — max 8, ordonnés par date décroissante
        \Log::info('--- Recherche des articles vedettes ---');
        
        // Vérification 1 : Compter tous les produits avec is_featured = true (sans filtre status)
        $totalFeatured = Product::where('is_featured', true)->count();
        \Log::info('Total des produits avec is_featured = true (tous statuts confondus) : ' . $totalFeatured);
        
        // Vérification 2 : Compter les produits vedettes avec status = published
        $publishedFeatured = Product::where('status', 'published')
            ->where('is_featured', true)
            ->count();
        \Log::info('Produits vedettes avec status = published : ' . $publishedFeatured);
        
        // Vérification 3 : Lister tous les produits vedettes avec leurs détails
        $allFeaturedProducts = Product::where('is_featured', true)
            ->select('id', 'name', 'status', 'is_featured', 'created_at')
            ->get();
        
        if ($allFeaturedProducts->isEmpty()) {
            \Log::warning('AUCUN produit n\'a is_featured = true dans la base de données !');
        } else {
            \Log::info('Liste des produits avec is_featured = true :');
            foreach ($allFeaturedProducts as $fp) {
                \Log::info("  - ID: {$fp->id}, Nom: {$fp->name}, Status: {$fp->status}, is_featured: {$fp->is_featured}");
            }
        }
        
        // Récupération réelle des vedettes
        $featured = Product::with(['category', 'images', 'colors'])
                ->where('status', 'published')
                ->where('is_featured', true)
                ->latest()
                // ->take(8)
                ->get();
        
        \Log::info('Articles vedettes récupérés (après filtre) : ' . $featured->count());
        
        if ($featured->isEmpty()) {
            \Log::warning('⚠️ AUCUNE vedette récupérée ! Vérifiez que :');
            \Log::warning('   1. Des produits ont is_featured = 1 (true) en base de données');
            \Log::warning('   2. Ces produits ont status = "published"');
            \Log::warning('   3. La colonne is_featured existe bien dans la table products');
        } else {
            \Log::info('Détails des vedettes récupérées :');
            foreach ($featured as $key => $item) {
                \Log::info("  Vedette " . ($key+1) . " : ID={$item->id}, Nom={$item->name}, Status={$item->status}, Featured={$item->is_featured}");
            }
        }

        // Récupération des catégories, marques et couleurs
        
        $categories = Cache::remember('categories_all', 3600, fn() => Category::all());
        $brands     = Cache::remember('brands_all',     3600, fn() => Brand::all());
        $colors     = Cache::remember('colors_all',     3600, fn() => Color::all());

        // Vérification finale avant d'envoyer à la vue
        \Log::info('=== DONNÉES ENVOYÉES À LA VUE ===');
        \Log::info('products.count = ' . $products->count());
        \Log::info('featured.count = ' . $featured->count());
        \Log::info('categories.count = ' . $categories->count());
        \Log::info('brands.count = ' . $brands->count());
        \Log::info('colors.count = ' . $colors->count());
        
        \Log::info('=== FIN DE LA MÉTHODE INDEX ===');

        return view('frontend.index', compact('products', 'categories', 'brands', 'colors', 'featured'));
    }

    // Même chose dans la méthode product()
    public function product(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images', 'colors', 'specifications'])
                        ->where('status', 'published');

        // ── Filtre catégorie ──────────────────────────────────────
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // ── Filtre marque ─────────────────────────────────────────
        if ($request->filled('brand') && $request->brand !== 'all') {
            $query->where('brand_id', $request->brand);
        }

        // ── Filtre couleur ────────────────────────────────────────
        if ($request->filled('color') && $request->color !== 'all') {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // ── Filtre prix ───────────────────────────────────────────
        if ($request->filled('price') && $request->price !== 'all') {
            if ($request->price === '500000+') {
                $query->where('price', '>=', 500000);
            } else {
                [$min, $max] = explode('-', $request->price);
                $query->whereBetween('price', [(int)$min, (int)$max]);
            }
        }

        // ── Filtre recherche ──────────────────────────────────────
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                ->orWhere('description', 'like', $term);
            });
        }

        // ── Tri ───────────────────────────────────────────────────
        match ($request->sort ?? 'default') {
            'price-asc'  => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            default      => $query->inRandomOrder(),
        };

        $products = $query->paginate(12)->withQueryString();

        // ── Réponse AJAX ──────────────────────────────────────────
        if ($request->expectsJson()) {
            
            return response()->json([
                'html'      => view('frontend.partials.product-items', compact('products'))->render(),
                'has_more'  => $products->hasMorePages(),
                'next_page' => $products->currentPage() + 1,
                'total'     => $products->total(),
                'current_page' => $products->currentPage(),
            ]);
        }

        $categories     = Category::all();
        $brands         = Brand::all();
        $colors         = Color::all();
        $activeCategory = $request->category ?? null;

        return view('frontend.product', compact('products', 'categories', 'brands', 'colors', 'activeCategory'));
    }
    
    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'images', 'colors', 'specifications'])
                        ->findOrFail($id);
        
        return response()->json(['product' => $product]);

    }
    
    
    public function details($id)
    {
        $product = Product::with(['category', 'brand', 'images', 'colors', 'specifications'])
                        ->findOrFail($id);

        // ══════════════════════════════════════════
        // LOGIQUE SIMILARITÉ PAR PRIORITÉ
        // ══════════════════════════════════════════

        $relatedProducts = collect();

        $keywords = collect(explode(' ', $product->name))
            ->filter(fn($w) => strlen($w) > 3) // ignorer "de", "la", etc.
            ->take(2);

        if ($keywords->isNotEmpty() && $relatedProducts->count() < 4) {
            $query = Product::with(['images', 'colors'])
                ->where('status', 'published')
                ->where('id', '!=', $product->id)
                ->where('category_id', $product->category_id)
                ->whereNotIn('id', $relatedProducts->pluck('id'));

            foreach ($keywords as $kw) {
                $query->where('name', 'like', "%{$kw}%");
            }

            $level1b = $query->limit(15 - $relatedProducts->count())->get();
            $relatedProducts = $relatedProducts->merge($level1b);
        }
        
        // ── Niveau 1 : même marque + même catégorie (les plus pertinents)
        if ($product->brand_id) {
            $level1 = Product::with(['images', 'colors'])
                ->where('status', 'published')
                ->where('id', '!=', $product->id)
                ->where('category_id', $product->category_id)
                ->where('brand_id', $product->brand_id)
                ->limit(6)
                ->get();

            $relatedProducts = $relatedProducts->merge($level1);
        }


        // ── Niveau 3 : même catégorie simplement
        // (dernier recours si toujours pas assez)
        if ($relatedProducts->count() < 4) {
            $level3 = Product::with(['images', 'colors'])
                ->where('status', 'published')
                ->where('id', '!=', $product->id)
                ->where('category_id', $product->category_id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->inRandomOrder()
                ->limit(6 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->merge($level3);
        }

        // ── Niveau 4 : même marque, autre catégorie
        // (si vraiment rien dans la catégorie)
        if ($relatedProducts->count() < 2 && $product->brand_id) {
            $level4 = Product::with(['images', 'colors'])
                ->where('status', 'published')
                ->where('id', '!=', $product->id)
                ->where('brand_id', $product->brand_id)
                ->whereNotIn('id', $relatedProducts->pluck('id'))
                ->limit(6 - $relatedProducts->count())
                ->get();

            $relatedProducts = $relatedProducts->merge($level4);
        }

        $relatedProducts = $relatedProducts->take(15);

        $categories = Category::all();

        return view('frontend.product-detail', compact('product', 'relatedProducts', 'categories'));
    }

    
    public function faqs()
    {
        return view('frontend.faq');
    }

    
    public function about()
    {
        return view('frontend.about');
    }

    
    public function new()
    {
        return view('frontend.news');
    }

    
    public function shoping()
    {
        return view('frontend.shoping-cart');
    }

    
    public function contact()
    {
        return view('frontend.contact');
    }
}
