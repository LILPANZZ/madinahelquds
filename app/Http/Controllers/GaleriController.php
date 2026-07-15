<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::latest()->paginate(12);
        return view('admin.galeri.index', compact('galeris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $paths = [];
            foreach ($request->file('gambar') as $file) {
                $paths[] = $file->store('galeri', 'public');
            }
            $validated['gambar'] = $paths;
        }

        Galeri::create($validated);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function update(Request $request, Galeri $galeri)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image deletion
        $currentImages = is_array($galeri->gambar) ? $galeri->gambar : (is_string($galeri->gambar) && $galeri->gambar ? [$galeri->gambar] : []);
        $imagesToKeep = [];

        if ($request->has('delete_gambar')) {
            $imagesToDelete = $request->delete_gambar;
            foreach ($currentImages as $oldPath) {
                if (in_array($oldPath, $imagesToDelete)) {
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                } else {
                    $imagesToKeep[] = $oldPath;
                }
            }
        } else {
            $imagesToKeep = $currentImages;
        }

        // Handle new images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $imagesToKeep[] = $file->store('galeri', 'public');
            }
        }

        $validated['gambar'] = $imagesToKeep;

        $galeri->update($validated);

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        if (is_array($galeri->gambar)) {
            foreach ($galeri->gambar as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        } elseif ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Foto berhasil dihapus dari galeri.');
    }
}
