<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatans = Kegiatan::latest()->get();
        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'required|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $paths = [];
            foreach ($request->file('foto') as $file) {
                $paths[] = $file->store('kegiatan', 'public');
            }
            $validated['foto'] = $paths;
        }

        Kegiatan::create($validated);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image deletion
        $currentImages = is_array($kegiatan->foto) ? $kegiatan->foto : (is_string($kegiatan->foto) && $kegiatan->foto ? [$kegiatan->foto] : []);
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
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $imagesToKeep[] = $file->store('kegiatan', 'public');
            }
        }

        $validated['foto'] = $imagesToKeep;

        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        if (is_array($kegiatan->foto)) {
            foreach ($kegiatan->foto as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        } elseif ($kegiatan->foto && Storage::disk('public')->exists($kegiatan->foto)) {
            Storage::disk('public')->delete($kegiatan->foto);
        }
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }
}
