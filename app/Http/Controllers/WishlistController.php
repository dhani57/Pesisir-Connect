<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan daftar produk yang disimpan oleh user.
     */
    public function index()
    {
        $wishlists = Wishlist::with(['product', 'product.category', 'product.vendor'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('frontend.saved', compact('wishlists'));
    }

    /**
     * Menyimpan atau menghapus produk dari wishlist (toggle).
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Produk dihapus dari daftar simpanan.');
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return back()->with('success', 'Produk berhasil disimpan ke daftar simpanan.');
        }
    }
}
