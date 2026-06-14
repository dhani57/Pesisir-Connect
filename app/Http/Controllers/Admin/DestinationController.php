<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::orderBy('sort_order')->orderBy('name')->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create(): View
    {
        return view('admin.destinations.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'tagline'     => 'nullable|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'highlights'  => 'nullable|string',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'   => 'nullable|url|max:2048',
        ]);

        $validated['highlights'] = $this->parseHighlights($request->input('highlights'));
        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['slug']       = \Illuminate\Support\Str::slug($validated['name']);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('destinations', 'public');
            $validated['image'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        unset($validated['image_file']);
        unset($validated['image_url']);

        Destination::create($validated);

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil ditambahkan.');
    }

    public function edit(Destination $destination): View
    {
        return view('admin.destinations.form', compact('destination'));
    }

    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'tagline'     => 'nullable|string|max:255',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'highlights'  => 'nullable|string',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'reviews_count' => 'nullable|integer|min:0',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'   => 'nullable|url|max:2048',
        ]);

        $validated['highlights'] = $this->parseHighlights($request->input('highlights'));
        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['slug']       = \Illuminate\Support\Str::slug($validated['name']);

        if ($request->hasFile('image_file')) {
            if ($destination->image && str_starts_with($destination->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $destination->image));
            }
            $path = $request->file('image_file')->store('destinations', 'public');
            $validated['image'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            if ($destination->image && str_starts_with($destination->image, '/storage/') && $destination->image !== $request->input('image_url')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $destination->image));
            }
            $validated['image'] = $request->input('image_url');
        }

        unset($validated['image_file']);
        unset($validated['image_url']);

        $destination->update($validated);

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        if ($destination->image && str_starts_with($destination->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $destination->image));
        }
        
        $destination->delete();
        
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil dihapus.');
    }

    /**
     * Parse comma-separated highlights or newline-separated string into an array.
     *
     * @return array<string>|null
     */
    private function parseHighlights(?string $input): ?array
    {
        if (empty($input)) {
            return [];
        }

        if (str_contains($input, "\n")) {
            return array_values(array_filter(array_map('trim', explode("\n", $input))));
        }

        return array_values(array_filter(array_map('trim', explode(',', $input))));
    }
}
