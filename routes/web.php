<?php

use App\Http\Controllers\Admin\KomentarController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    $beritas = \App\Models\Berita::latest('tanggal')->take(3)->get();
    $galeris = \App\Models\Galeri::latest()->take(8)->get();
    $kegiatans = \App\Models\Kegiatan::latest('tanggal')->take(4)->get();
    $fasilitas = \App\Models\Fasilitas::latest()->take(3)->get();
    $pengumumans = \App\Models\Pengumuman::where('status', 'aktif')
        ->whereDate('tanggal_mulai', '<=', now())
        ->where(function($q) {
            $q->whereNull('tanggal_selesai')
              ->orWhereDate('tanggal_selesai', '>=', now());
        })
        ->orderByRaw("FIELD(kategori, 'penting', 'akademik', 'kegiatan', 'umum')")
        ->latest()
        ->take(5)
        ->get();
    $prestasis = \App\Models\Prestasi::latest('tanggal')->take(6)->get(); // ✅ tambahkan ini
    $profil = \App\Models\Profil::first();

    return view('welcome', compact('beritas', 'galeris', 'kegiatans', 'fasilitas', 'pengumumans', 'prestasis', 'profil')); // ✅ tambah prestasis dan profil
})->name('welcome');

// Berita detail page
Route::get('/berita/{judul}', function ($judul) {
    $berita = \App\Models\Berita::where('judul', $judul)->firstOrFail();
    $beritaTerbaru = \App\Models\Berita::latest('tanggal')->take(5)->get();
    $komentars = $berita->komentars()->whereNull('parent_id')->with('replies')->latest()->get();
    
    return view('berita.detail', compact('berita', 'beritaTerbaru', 'komentars'));
})->name('berita.detail');

Route::post('/berita/{judul}/komentar', function (\Illuminate\Http\Request $request, $judul) {
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'komentar' => 'required|string',
        'parent_id' => 'nullable|exists:komentars,id'
    ]);
    
    $berita = \App\Models\Berita::where('judul', $judul)->firstOrFail();
    
    $berita->komentars()->create([
        'nama' => $request->nama,
        'email' => $request->email,
        'komentar' => $request->komentar,
        'parent_id' => $request->parent_id,
    ]);
    
    return back()->with('success', 'Komentar Anda telah berhasil dikirim.');
})->name('berita.komentar');

// Kegiatan detail page
Route::get('/kegiatan/{id}', function ($id) {
    $kegiatan = \App\Models\Kegiatan::findOrFail($id);
    return view('kegiatan.detail', compact('kegiatan'));
})->name('kegiatan.detail');

// Tentang Kami page
Route::get('/tentang-kami', function () {
    $profil = \App\Models\Profil::first();
    return view('tentang', compact('profil'));
})->name('tentang');

// Kehidupan di Jogja page
Route::get('/kehidupan-di-jogja', function () {
    return view('jogja.index');
})->name('jogja.index');

// Fasilitas Sekolah page
Route::get('/fasilitas-sekolah', function () {
    $fasilitas = \App\Models\Fasilitas::all();
    return view('fasilitas.index', compact('fasilitas'));
})->name('fasilitas.public.index');

// Prestasi page
Route::get('/prestasi', function () {
    $prestasis = \App\Models\Prestasi::latest('tanggal')->get();
    return view('prestasi.index', compact('prestasis'));
})->name('prestasi.public.index');

// Kegiatan Ekstrakurikuler page
Route::get('/kegiatan-ekstrakurikuler', function () {
    $kegiatans = \App\Models\Kegiatan::latest('tanggal')->get();
    return view('ekstrakurikuler.index', compact('kegiatans'));
})->name('ekstrakurikuler.index');

// Galeri page
Route::get('/galeri', function () {
    $galeris = \App\Models\Galeri::latest()->get();
    return view('galeri.index', compact('galeris'));
})->name('galeri.public.index');

// Berita Terkini page
Route::get('/berita-terkini', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Berita::query();
    if ($request->has('kategori')) {
        $query->where('kategori', $request->kategori);
    }
    $beritas = $query->latest('tanggal')->get();
    return view('berita.index', compact('beritas'));
})->name('berita.public.index');

// Search page
Route::get('/search', function (\Illuminate\Http\Request $request) {
    $query = $request->input('q');
    
    if (!$query) {
        return redirect()->route('welcome');
    }
    
    $words = array_filter(explode(' ', $query));
    
    $applySearch = function ($q, $columns) use ($words) {
        foreach ($words as $word) {
            $q->where(function ($subq) use ($columns, $word) {
                foreach ($columns as $column) {
                    $subq->orWhere($column, 'like', "%{$word}%");
                }
            });
        }
    };
    
    // Search in Berita
    $beritaQuery = \App\Models\Berita::query();
    $applySearch($beritaQuery, ['judul', 'deskripsi']);
    $beritas = $beritaQuery->latest('tanggal')->get();
    
    // Search in Kegiatan
    $kegiatanQuery = \App\Models\Kegiatan::query();
    $applySearch($kegiatanQuery, ['judul', 'deskripsi', 'tempat']);
    $kegiatans = $kegiatanQuery->latest('tanggal')->get();
    
    // Search in Fasilitas
    $fasilitasQuery = \App\Models\Fasilitas::query();
    $applySearch($fasilitasQuery, ['nama', 'deskripsi', 'kategori']);
    $fasilitas = $fasilitasQuery->get();
    
    // Search in Galeri
    $galeriQuery = \App\Models\Galeri::query();
    $applySearch($galeriQuery, ['judul', 'deskripsi', 'kategori']);
    $galeris = $galeriQuery->get();
        
    // Search in Prestasi
    $prestasiQuery = \App\Models\Prestasi::query();
    $applySearch($prestasiQuery, ['judul_prestasi', 'deskripsi', 'kategori']);
    $prestasis = $prestasiQuery->latest('tanggal')->get();
    
    return view('search.results', compact('query', 'beritas', 'kegiatans', 'fasilitas', 'galeris', 'prestasis'));
})->name('search');

// Redirect default login to admin login
Route::get('/login', function () {
    return redirect()->route('admin.login.form');
})->name('login');

// Admin Authentication Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
});

// Admin Routes (Authenticated only)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Logout
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Dashboard - redirect to berita
    Route::get('/dashboard', function () {
        return redirect()->route('admin.berita.index');
    })->name('dashboard');

    // Berita CRUD
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    // Prestasi CRUD
    Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::put('/prestasi/{prestasi}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::delete('/prestasi/{prestasi}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');

    // Galeri CRUD
    Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::put('/galeri/{galeri}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

    // Kegiatan CRUD
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::put('/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // Fasilitas CRUD
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('/fasilitas/{fasilita}', [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::delete('/fasilitas/{fasilita}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');

    // Pengumuman CRUD
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    // Profil Routes
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [ProfilController::class, 'store'])->name('profil.store');
    Route::put('/profil/{profil}', [ProfilController::class, 'update'])->name('profil.update');

    // Komentar Routes (Read & Delete only)
    Route::get('/komentar', [KomentarController::class, 'index'])->name('komentar.index');
    Route::delete('/komentar/{komentar}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
});

Route::get('/test-asset', function() { return asset('storage/test.jpg'); });

 


