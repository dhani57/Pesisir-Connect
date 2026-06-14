<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'image_type' => 'required|in:upload,url',
            'image_file' => 'nullable|image|max:2048|required_if:image_type,upload',
            'image_url' => 'nullable|url|max:2048|required_if:image_type,url',
        ]);

        $imagePath = null;
        if ($request->image_type === 'upload' && $request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('categories', 'public');
        } elseif ($request->image_type === 'url') {
            $imagePath = $request->image_url;
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'image_type' => 'required|in:upload,url',
            'image_file' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url|max:2048|required_if:image_type,url',
        ]);

        $imagePath = $category->image;
        
        if ($request->image_type === 'upload') {
            if ($request->hasFile('image_file')) {
                if ($category->image && !Str::startsWith($category->image, ['http://', 'https://'])) {
                    Storage::disk('public')->delete($category->image);
                }
                $imagePath = $request->file('image_file')->store('categories', 'public');
            }
        } elseif ($request->image_type === 'url') {
            if ($category->image && !Str::startsWith($category->image, ['http://', 'https://'])) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->image_url;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        // Ideally we should check if products are attached to this category before deleting.
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
