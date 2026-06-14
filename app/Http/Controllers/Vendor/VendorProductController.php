<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\VendorNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorProductController extends Controller
{
    /**
     * List vendor's products with search, filter, sort, pagination.
     */
    public function index(Request $request): View
    {
        $vendor = auth()->user()->vendor;

        $query = Product::where('vendor_id', $vendor->id);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Sort
        $sortBy = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        $allowedSorts = ['name', 'price', 'stock', 'created_at', 'status'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $products = $query->with('category')->paginate(20)->withQueryString();

        return view('vendor.products.index', compact('products', 'vendor'));
    }

    /**
     * Show create product form.
     */
    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        return view('vendor.products.create', compact('categories'));
    }

    /**
     * Store a new product.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        $data = $request->validated();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = 'storage/' . $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        // Handle gallery
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = 'storage/' . $image->store('products/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        // Handle facilities (comma-separated → array)
        if (isset($data['facilities']) && is_string($data['facilities'])) {
            $data['facilities'] = array_map('trim', explode(',', $data['facilities']));
        }

        $data['user_id'] = auth()->id();
        $data['vendor_id'] = $vendor->id;
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);

        Product::create($data);

        $action = $request->input('action', 'save');
        if ($action === 'save_and_add') {
            return redirect()->route('vendor.products.create')
                ->with('success', 'Produk berhasil ditambahkan! Silakan tambah produk lainnya.');
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show edit product form.
     */
    public function edit(Product $product): View
    {
        // Verify ownership
        $this->authorizeVendorProduct($product);

        $categories = Category::active()->ordered()->get();
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update a product.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorizeVendorProduct($product);
        $data = $request->validated();

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($product->thumbnail) {
                $oldPath = str_replace('storage/', '', $product->thumbnail);
                Storage::disk('public')->delete($oldPath);
            }
            $data['thumbnail'] = 'storage/' . $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        // Handle gallery
        if ($request->hasFile('gallery')) {
            // Delete old gallery
            if ($product->gallery) {
                foreach ($product->gallery as $oldImage) {
                    $oldPath = str_replace('storage/', '', $oldImage);
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $galleryPaths[] = 'storage/' . $image->store('products/gallery', 'public');
            }
            $data['gallery'] = $galleryPaths;
        }

        // Handle facilities
        if (isset($data['facilities']) && is_string($data['facilities'])) {
            $data['facilities'] = array_map('trim', explode(',', $data['facilities']));
        }

        $product->update($data);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeVendorProduct($product);

        // Delete images
        if ($product->thumbnail) {
            $oldPath = str_replace('storage/', '', $product->thumbnail);
            Storage::disk('public')->delete($oldPath);
        }
        if ($product->gallery) {
            foreach ($product->gallery as $image) {
                $oldPath = str_replace('storage/', '', $image);
                Storage::disk('public')->delete($oldPath);
            }
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Toggle product status (active/inactive).
     */
    public function toggleStatus(Product $product): RedirectResponse
    {
        $this->authorizeVendorProduct($product);

        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        return back()->with('success', 'Status produk berhasil diubah menjadi ' . ($newStatus === 'active' ? 'aktif' : 'nonaktif') . '.');
    }

    /**
     * Verify vendor owns this product (via Policy).
     */
    private function authorizeVendorProduct(Product $product): void
    {
        $this->authorize('update', $product);
    }
}
