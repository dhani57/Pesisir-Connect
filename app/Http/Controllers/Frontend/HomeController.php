<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): View
    {
        $categories = Category::active()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->active()])
            ->get();

        $featuredProducts = Product::active()
            ->featured()
            ->with(['category', 'vendor'])
            ->latest()
            ->take(8)
            ->get();

        $locations = Product::active()
            ->select('location')
            ->distinct()
            ->pluck('location');

        return view('welcome', compact(
            'categories',
            'featuredProducts',
            'locations',
        ));
    }

    /**
     * Display the product catalog (listing page) with enhanced filters.
     */
    public function catalog(Request $request): View
    {
        $query = Product::active()->with(['category', 'vendor']);

        // Full-text search (name + description)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->kategori));
        }

        // Filter by location
        if ($request->filled('lokasi')) {
            $query->byLocation($request->lokasi);
        }

        // Filter by price range
        if ($request->filled('harga_min')) {
            $query->where('price', '>=', (float) $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('price', '<=', (float) $request->harga_max);
        }

        // Filter by minimum rating
        if ($request->filled('rating_min')) {
            $query->where('rating', '>=', (float) $request->rating_min);
        }

        // Filter by capacity
        if ($request->filled('kapasitas_min')) {
            $query->where('capacity', '>=', (int) $request->kapasitas_min);
        }

        // Sort
        $query->when($request->sort, function ($q, $sort) {
            return match ($sort) {
                'price_low'  => $q->orderBy('price', 'asc'),
                'price_high' => $q->orderBy('price', 'desc'),
                'rating'     => $q->orderBy('rating', 'desc'),
                'newest'     => $q->latest(),
                'popular'    => $q->orderBy('total_reviews', 'desc'),
                default      => $q->orderBy('sort_order')->latest(),
            };
        }, fn ($q) => $q->orderBy('sort_order')->latest());

        $products   = $query->paginate(12);
        $categories = Category::active()->ordered()->get();
        $locations  = Product::active()->select('location')->distinct()->pluck('location');

        // Get price range for the slider
        $priceRange = [
            'min' => (int) Product::active()->min('price'),
            'max' => (int) Product::active()->max('price'),
        ];

        return view('frontend.catalog', compact(
            'products',
            'categories',
            'locations',
            'priceRange',
        ));
    }

    /**
     * Return search suggestions for autocomplete (AJAX).
     */
    public function searchSuggestions(Request $request): JsonResponse
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->where('name', 'like', "%{$query}%")
            ->select('name', 'slug', 'location', 'price')
            ->take(5)
            ->get()
            ->map(fn ($p) => [
                'name'     => $p->name,
                'slug'     => $p->slug,
                'location' => $p->location,
                'price'    => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'url'      => route('produk.detail', $p->slug),
            ]);

        return response()->json($products);
    }
}
