<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Profil::first();
        return view('admin.profil.index', compact('profil'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pondok' => 'required|string|max:255',
            'pengasuh' => 'required|string|max:255',
            'tahun_berdiri' => 'required|string|max:10',
            'jumlah_santri' => 'required|integer',
            'jumlah_ustadz' => 'required|integer',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'website' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
        ]);

        Profil::create($validated);

        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil ditambahkan');
    }

    public function update(Request $request, Profil $profil)
    {
        $validated = $request->validate([
            'nama_pondok' => 'required|string|max:255',
            'pengasuh' => 'required|string|max:255',
            'tahun_berdiri' => 'required|string|max:10',
            'jumlah_santri' => 'required|integer',
            'jumlah_ustadz' => 'required|integer',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'website' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
        ]);

        $profil->update($validated);

        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui');
    }
}
