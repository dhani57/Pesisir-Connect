<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
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
     * Display the product catalog (listing page).
     */
    public function catalog(Request $request): View
    {
        $query = Product::active()->with(['category', 'vendor']);

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->byLocation($request->location);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $query->when($request->sort, function ($q, $sort) {
            return match ($sort) {
                'price_low'  => $q->orderBy('price', 'asc'),
                'price_high' => $q->orderBy('price', 'desc'),
                'rating'     => $q->orderBy('rating', 'desc'),
                'newest'     => $q->latest(),
                default      => $q->orderBy('sort_order')->latest(),
            };
        }, fn ($q) => $q->orderBy('sort_order')->latest());

        $products   = $query->paginate(12);
        $categories = Category::active()->ordered()->get();
        $locations  = Product::active()->select('location')->distinct()->pluck('location');

        return view('frontend.catalog', compact(
            'products',
            'categories',
            'locations',
        ));
    }
}
