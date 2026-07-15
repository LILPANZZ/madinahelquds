<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'jumlah_kapasitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $paths = [];
            foreach ($request->file('gambar') as $file) {
                $paths[] = $file->store('fasilitas', 'public');
            }
            $validated['gambar'] = $paths;
        }

        Fasilitas::create($validated);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fasilitas $fasilita)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'jumlah_kapasitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image deletion
        $currentImages = is_array($fasilita->gambar) ? $fasilita->gambar : (is_string($fasilita->gambar) && $fasilita->gambar ? [$fasilita->gambar] : []);
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
                $imagesToKeep[] = $file->store('fasilitas', 'public');
            }
        }

        $validated['gambar'] = $imagesToKeep;

        $fasilita->update($validated);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fasilitas $fasilita)
    {
        if (is_array($fasilita->gambar)) {
            foreach ($fasilita->gambar as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        } elseif ($fasilita->gambar && Storage::disk('public')->exists($fasilita->gambar)) {
            Storage::disk('public')->delete($fasilita->gambar);
        }
        $fasilita->delete();

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus');
    }
}
