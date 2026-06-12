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
        $destinations = Destination::orderBy('name')->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create(): View
    {
        return view('admin.destinations.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('destinations', 'public');
            $validated['image'] = '/storage/' . $path;
        }

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
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($destination->image && str_starts_with($destination->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $destination->image));
            }
            $path = $request->file('image')->store('destinations', 'public');
            $validated['image'] = '/storage/' . $path;
        }

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
}
