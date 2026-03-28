<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;

class ClientController extends Controller
{
    //

    public function index()
    {
        $products = Product::with(['category', 'brand', 'images', 'colors', 'specifications'])
                ->where('status', 'published')
                ->inRandomOrder()
                ->get();
        
        $categories = Category::all();
        $brands     = Brand::all();
        $colors     = Color::all(); 

        return view('frontend.index', compact('products', 'categories', 'brands', 'colors'));
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
