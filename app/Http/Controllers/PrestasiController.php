<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasis = Prestasi::latest()->paginate(10);
        return view('admin.prestasi.index', compact('prestasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_prestasi' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal' => 'required|date',
        ]);

        if ($request->hasFile('gambar')) {
            $paths = [];
            foreach ($request->file('gambar') as $file) {
                $paths[] = $file->store('prestasi', 'public');
            }
            $validated['gambar'] = $paths;
        }

        Prestasi::create($validated);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate([
            'judul_prestasi' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal' => 'required|date',
        ]);

        // Handle image deletion
        $currentImages = is_array($prestasi->gambar) ? $prestasi->gambar : (is_string($prestasi->gambar) && $prestasi->gambar ? [$prestasi->gambar] : []);
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
                $imagesToKeep[] = $file->store('prestasi', 'public');
            }
        }

        $validated['gambar'] = $imagesToKeep;

        $prestasi->update($validated);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if (is_array($prestasi->gambar)) {
            foreach ($prestasi->gambar as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        } elseif ($prestasi->gambar && Storage::disk('public')->exists($prestasi->gambar)) {
            Storage::disk('public')->delete($prestasi->gambar);
        }

        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
