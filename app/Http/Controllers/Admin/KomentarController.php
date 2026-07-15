<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;

class KomentarController extends Controller
{
    public function index()
    {
        $komentars = Komentar::with('berita')
            ->whereNull('parent_id')
            ->latest()
            ->get();

        $replies = Komentar::with('berita', 'parent')
            ->whereNotNull('parent_id')
            ->latest()
            ->get();

        $allKomentars = Komentar::with('berita', 'parent')
            ->latest()
            ->paginate(15);

        return view('admin.komentar.index', compact('allKomentars'));
    }

    public function destroy(Komentar $komentar)
    {
        // Hapus juga semua balasan dari komentar ini
        $komentar->replies()->delete();
        $komentar->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
