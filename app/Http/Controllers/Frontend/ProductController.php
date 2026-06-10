<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman detail produk wisata
     */
    public function show(string $slug): View
    {
        // Cari berdasarkan slug, atau fallback ke ID
        $product = Product::active()
            ->with(['category', 'vendor'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $isSaved = false;
        if (auth()->check()) {
            $isSaved = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('frontend.produk-detail', compact('product', 'isSaved'));
    }
}
