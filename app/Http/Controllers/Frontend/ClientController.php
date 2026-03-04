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
                        ->latest()
                        ->get();
        
        $categories = Category::all();
        $brands     = Brand::all();
        $colors     = Color::all(); // ← ajouter

        return view('frontend.index', compact('products', 'categories', 'brands', 'colors'));
    }

    // Même chose dans la méthode product()
    public function product(Request $request)
{
    $query = Product::with(['category', 'brand', 'images', 'colors', 'specifications'])
                    ->where('status', 'published')
                    ->latest();

    if ($request->has('category') && $request->category !== null) {
        $query->where('category_id', $request->category);
    }

    // Pagination AJAX : retourner JSON si demandé
    if ($request->expectsJson()) {
        $products = $query->paginate(12);
        return response()->json([
            'html'     => view('frontend.partials.product-items', compact('products'))->render(),
            'has_more' => $products->hasMorePages(),
            'next_page' => $products->currentPage() + 1,
        ]);
    }

    $products   = $query->paginate(12);
    $categories = Category::all();
    $brands     = Brand::all();
    $colors     = Color::all();
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
