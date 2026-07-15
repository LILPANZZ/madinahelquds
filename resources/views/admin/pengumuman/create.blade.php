@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')
@section('page-title', 'Tambah Pengumuman')

@section('content')
<div class="p-6">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.pengumuman.index') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pengumuman</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Pengumuman</label>
                    <input type="text" name="judul" id="prev-judul" value="{{ old('judul') }}"
                        placeholder="Masukkan judul pengumuman"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('judul') border-red-500 @enderror"
                        oninput="updatePreview()">
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" id="prev-kategori" onchange="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('kategori') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="penting" {{ old('kategori') == 'penting' ? 'selected' : '' }}>Penting</option>
                        <option value="akademik" {{ old('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Pengumuman</label>
                    <textarea name="isi" id="prev-isi" rows="5"
                        placeholder="Tulis isi pengumuman di sini..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('isi') border-red-500 @enderror"
                        oninput="updatePreview()">{{ old('isi') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="prev-status" onchange="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="prev-tgl-mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                            oninput="updatePreview()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai (Opsional)</label>
                        <input type="date" name="tanggal_selesai" id="prev-tgl-selesai" value="{{ old('tanggal_selesai') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                            oninput="updatePreview()">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran (Opsional)</label>
                    <input type="file" name="lampiran"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, DOCX, XLSX. Maks: 5MB</p>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl transition">Simpan Pengumuman</button>
                    <a href="{{ route('admin.pengumuman.index') }}" class="border border-gray-300 text-gray-700 px-6 py-2 rounded-xl hover:bg-gray-50 transition">Batal</a>
                </div>
            </form>
        </div>

        <!-- Live Preview -->
        <div class="md:sticky md:top-6">
            <p class="text-sm font-medium text-gray-500 mb-3 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Preview Tampilan Publik
            </p>
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-2">
                <div id="preview-card" class="bg-white rounded-xl shadow-md p-5 flex items-start gap-4 text-left border-l-4 border-gray-400">
                    <div id="preview-icon" class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-sm bg-gradient-to-br from-gray-500 to-gray-600 text-white">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 id="preview-judul-text" class="font-bold text-gray-900 text-lg">Judul Pengumuman</h3>
                            <span id="preview-status-badge" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>Aktif
                            </span>
                        </div>
                        <p id="preview-isi-text" class="text-gray-600 text-sm leading-relaxed">Isi pengumuman akan tampil di sini...</p>
                        <div class="flex items-center gap-4 mt-3 text-xs">
                            <span id="preview-kategori-badge" class="inline-flex items-center px-2.5 py-1 rounded-full font-medium bg-gray-100 text-gray-700">Umum</span>
                            <span id="preview-tanggal-text" class="text-gray-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Tanggal
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const kategoriConfig = {
    penting:  { border: 'border-red-500',   icon: 'from-red-500 to-red-600',     badge: 'bg-red-100 text-red-700',   label: 'Penting'  },
    akademik: { border: 'border-blue-500',  icon: 'from-blue-500 to-blue-600',   badge: 'bg-blue-100 text-blue-700', label: 'Akademik' },
    kegiatan: { border: 'border-green-500', icon: 'from-green-500 to-green-600', badge: 'bg-green-100 text-green-700',label: 'Kegiatan' },
    umum:     { border: 'border-gray-400',  icon: 'from-gray-500 to-gray-600',   badge: 'bg-gray-100 text-gray-700', label: 'Umum'     },
};

function updatePreview() {
    const judul      = document.getElementById('prev-judul').value || 'Judul Pengumuman';
    const kategori   = document.getElementById('prev-kategori').value || 'umum';
    const isi        = document.getElementById('prev-isi').value || 'Isi pengumuman akan tampil di sini...';
    const status     = document.getElementById('prev-status').value;
    const tglMulai  = document.getElementById('prev-tgl-mulai').value;
    const tglSelesai = document.getElementById('prev-tgl-selesai').value;

    const cfg = kategoriConfig[kategori] || kategoriConfig.umum;
    const card = document.getElementById('preview-card');
    const icon = document.getElementById('preview-icon');

    // Update border & icon warna
    card.className = 'bg-white rounded-xl shadow-md p-5 flex items-start gap-4 text-left border-l-4 ' + cfg.border;
    icon.className = 'flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-sm bg-gradient-to-br text-white ' + cfg.icon;

    document.getElementById('preview-judul-text').textContent = judul;
    document.getElementById('preview-isi-text').textContent   = isi.substring(0, 150) + (isi.length > 150 ? '...' : '');
    document.getElementById('preview-kategori-badge').textContent = cfg.label;
    document.getElementById('preview-kategori-badge').className = 'inline-flex items-center px-2.5 py-1 rounded-full font-medium ' + cfg.badge;

    // Status badge
    const statusBadge = document.getElementById('preview-status-badge');
    if (status === 'aktif') {
        statusBadge.className = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800';
        statusBadge.innerHTML = '<span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>Aktif';
    } else {
        statusBadge.className = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700';
        statusBadge.innerHTML = '<span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1"></span>Nonaktif';
    }

    // Tanggal
    let tglText = '';
    if (tglMulai) {
        const d = new Date(tglMulai);
        tglText = d.toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'});
    }
    if (tglSelesai) {
        const d2 = new Date(tglSelesai);
        tglText += ' - ' + d2.toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'});
    }
    document.getElementById('preview-tanggal-text').innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>${tglText || 'Tanggal'}`;
}

updatePreview();
</script>
@endsection