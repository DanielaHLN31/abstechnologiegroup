<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query    = trim($request->get('q', ''));
        $category = $request->get('category');
        $brand    = $request->get('brand');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sort     = $request->get('sort', 'relevance');

        $products = Product::with(['images', 'category', 'brand', 'colors'])
            ->where('status', 'published')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%")
                        ->orWhereHas('brand', fn($b) => $b->where('name', 'LIKE', "%{$query}%"))
                        ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$query}%"));
                });
            })
            ->when($category, fn($q) => $q->where('category_id', $category))
            ->when($brand,    fn($q) => $q->where('brand_id', $brand))
            ->when($minPrice, fn($q) => $q->where('price', '>=', $minPrice))
            ->when($maxPrice, fn($q) => $q->where('price', '<=', $maxPrice))
            ->when($sort === 'price_asc',  fn($q) => $q->orderBy('price'))
            ->when($sort === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when($sort === 'newest',     fn($q) => $q->latest())
            ->when($sort === 'relevance' || !$sort, fn($q) => $q->orderByDesc('is_featured')->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();

        return view('frontend.search', compact(
            'products', 'query', 'categories', 'brands',
            'category', 'brand', 'minPrice', 'maxPrice', 'sort'
        ));
    }

    // AJAX — suggestions en temps réel (barre de recherche)
    public function suggest(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $results = Product::with('images')
            ->where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', "%{$q}%")
                      ->orWhereHas('brand',    fn($b) => $b->where('name', 'LIKE', "%{$q}%"))
                      ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$q}%"));
            })
            ->limit(6)
            ->get()
            ->map(fn($p) => [
                'id'    => $p->id,
                'name'  => $p->name,
                'price' => number_format($p->price, 0, ',', ' '),
                'image' => $p->images->first()?->image_path
                    ? asset('storage/' . $p->images->first()->image_path)
                    : asset('frontend/images/no-image.jpg'),
                'url'   => route('client.product.detail', $p->id),
            ]);

        return response()->json($results);
    }
}