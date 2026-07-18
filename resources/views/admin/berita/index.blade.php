@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page-title', 'Berita')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <!-- Form Tambah Berita -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-1">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Berita Baru
        </h3>

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita</label>
                <input type="text" name="judul" id="prev-judul" value="{{ old('judul') }}"
                    placeholder="Masukkan judul berita"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('judul') border-red-500 @enderror"
                    oninput="updatePreview()">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('kategori') border-red-500 @enderror">
                    <option value="Umum" {{ old('kategori') == 'Umum' ? 'selected' : '' }}>Umum</option>
                    <option value="Pendidikan" {{ old('kategori') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="Prestasi" {{ old('kategori') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="Kegiatan" {{ old('kategori') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="prev-deskripsi" rows="4"
                    placeholder="Masukkan deskripsi berita"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('deskripsi') border-red-500 @enderror"
                    oninput="updatePreview()">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="prev-tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('tanggal') border-red-500 @enderror"
                        oninput="updatePreview()">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar <button type="button" onclick="addFileInput('add-image-container', 'gambar[]', 'preview-img-new')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="add-image-container" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="gambar[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'preview-img-new')">
    </div>
</div>
                    <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF. Maks: 2MB</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">Simpan Berita</button>
                <button type="reset" onclick="resetPreview()" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition">Batal</button>
            </div>
        </form>
    </div>

    <!-- Live Preview -->
    <div class="lg:col-span-1 bg-white rounded-lg shadow-sm p-6 order-2 lg:sticky lg:top-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#2d5a3d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Preview Tampilan Publik
        </h3>
        <div class="border-2 border-dashed border-gray-200 rounded-xl p-1">
            <div class="bg-white rounded-xl overflow-hidden shadow-md">
                <img id="preview-img-new" src="https://placehold.co/600x300/e5e7eb/9ca3af?text=Gambar+Berita" alt="preview" class="w-full h-48 object-cover">
                <div class="p-5">
                    <span id="preview-tanggal-text" class="text-xs text-green-600 font-medium"></span>
                    <h3 id="preview-judul-text" class="font-bold text-gray-900 mt-2 mb-2 text-lg">Judul Berita</h3>
                    <p id="preview-deskripsi-text" class="text-gray-600 text-sm mb-4">Deskripsi berita akan tampil di sini...</p>
                    <span class="text-green-600 text-sm font-medium">Baca Selengkapnya →</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Berita -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Berita</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Gambar</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Judul</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Tanggal</th>
                        <th class="text-center py-3 px-4 text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $berita)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <img src="{{ asset('storage/' . (is_array($berita->gambar) && count($berita->gambar) > 0 ? $berita->gambar[0] : $berita->gambar)) }}" alt="{{ $berita->judul }}" class="w-20 h-14 object-cover rounded">
                            </td>
                            <td class="py-3 px-4">
                                <p class="font-medium text-gray-800">{{ $berita->judul }}</p>
                                <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit(strip_tags($berita->deskripsi), 100) }}</p>
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ $berita->tanggal->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex justify-center gap-2">
                                    <button onclick="editBerita({{ $berita->id }})" class="text-blue-500 hover:text-blue-700 p-1" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500">Belum ada berita. Silakan tambah berita baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $beritas->links() }}</div>
    </div>
</div>


@endsection

@section('scripts')
<script>
function updatePreview() {
    const judul = document.getElementById('prev-judul').value || 'Judul Berita';
    const deskripsi = document.getElementById('prev-deskripsi').value || 'Deskripsi berita akan tampil di sini...';
    const tanggal = document.getElementById('prev-tanggal').value;

    document.getElementById('preview-judul-text').textContent = judul;
    document.getElementById('preview-deskripsi-text').textContent = deskripsi.substring(0, 100) + (deskripsi.length > 100 ? '...' : '');
    if (tanggal) {
        const d = new Date(tanggal);
        document.getElementById('preview-tanggal-text').textContent = d.toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'});
    }
}

function resetPreview() {
    document.getElementById('preview-img-new').src = 'https://placehold.co/600x300/e5e7eb/9ca3af?text=Gambar+Berita';
    document.getElementById('preview-judul-text').textContent = 'Judul Berita';
    document.getElementById('preview-deskripsi-text').textContent = 'Deskripsi berita akan tampil di sini...';
    document.getElementById('preview-tanggal-text').textContent = '';
}

function previewImage(input, targetId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById(targetId).src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

function updateEditPreview(id, field, value) {
    if (field === 'judul') document.getElementById('edit-judul-' + id).textContent = value || 'Judul Berita';
    if (field === 'deskripsi') document.getElementById('edit-deskripsi-' + id).textContent = (value || '').substring(0, 100) + (value.length > 100 ? '...' : '');
    if (field === 'tanggal' && value) {
        const d = new Date(value);
        document.getElementById('edit-tanggal-' + id).textContent = d.toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'});
    }
}

function editBerita(id) {
    const modal = document.getElementById('edit-modal-' + id);
    
    // Reset state gambar yang dihapus jika sebelumnya dibatalkan
    modal.querySelectorAll('.img-item').forEach(el => el.style.display = '');
    modal.querySelectorAll('input[name="delete_gambar[]"]').forEach(el => el.remove());
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal(id) {
    document.getElementById('edit-modal-' + id).classList.add('hidden');
    document.getElementById('edit-modal-' + id).classList.remove('flex');
}

document.querySelectorAll('[id^="edit-modal-"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) { this.classList.add('hidden'); this.classList.remove('flex'); }
    });
});

updatePreview();
</script>

    <!-- Edit Modals -->
    @foreach($beritas as $berita)


                        <!-- Edit Modal dengan Preview -->
                        <div id="edit-modal-{{ $berita->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-lg p-6 w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Edit Berita</h3>
                                    <button onclick="closeEditModal({{ $berita->id }})" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita</label>
                                            <input type="text" name="judul" value="{{ $berita->judul }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                                oninput="updateEditPreview({{ $berita->id }}, 'judul', this.value)">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                            <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                                <option value="Umum" {{ $berita->kategori == 'Umum' ? 'selected' : '' }}>Umum</option>
                                                <option value="Pendidikan" {{ $berita->kategori == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                                <option value="Prestasi" {{ $berita->kategori == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                                <option value="Kegiatan" {{ $berita->kategori == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                                <option value="Pengumuman" {{ $berita->kategori == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                            <textarea name="deskripsi" rows="4"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                                oninput="updateEditPreview({{ $berita->id }}, 'deskripsi', this.value)">{{ $berita->deskripsi }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                                <input type="date" name="tanggal" value="{{ $berita->tanggal->format('Y-m-d') }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                                    oninput="updateEditPreview({{ $berita->id }}, 'tanggal', this.value)">
                                            </div>
                                            <div>
                                                @php
                                                    $rawImages = is_array($berita->gambar) ? $berita->gambar : (is_string($berita->gambar) && $berita->gambar ? [$berita->gambar] : []);
                                                    $images = array_values(array_filter($rawImages, fn($img) => !empty($img)));
                                                @endphp
                                                @if(count($images) > 0)
                                                <div class="mb-3">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                                                    <div class="flex flex-wrap gap-4">
                                                        @foreach($images as $img)
                                                            <div class="relative w-20 h-20 rounded border border-gray-200 overflow-hidden shadow-sm group img-item">
                                                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                                                <button type="button" onclick="removeImage('{{ $img }}', this)" style="position: absolute; top: 4px; right: 4px; z-index: 50; background-color: #ef4444; color: white; border-radius: 9999px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; cursor: pointer; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);" title="Hapus foto ini">X</button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif

                                                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Baru (Opsional) <button type="button" onclick="addFileInput('edit-image-container-{{ $berita->id }}', 'gambar[]', 'edit-img-{{ $berita->id }}')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="edit-image-container-{{ $berita->id }}" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="gambar[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'edit-img-{{ $berita->id }}')">
    </div>
</div>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 pt-2">
                                            <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">Update Berita</button>
                                            <button type="button" onclick="closeEditModal({{ $berita->id }})" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition">Batal</button>
                                        </div>
                                    </form>

                                    <!-- Preview Edit -->
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-3 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Preview Tampilan Publik
                                        </p>
                                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-1">
                                            <div class="bg-white rounded-xl overflow-hidden shadow-md">
                                                <img id="edit-img-{{ $berita->id }}" src="{{ asset('storage/' . (is_array($berita->gambar) && count($berita->gambar) > 0 ? $berita->gambar[0] : $berita->gambar)) }}" alt="preview" class="w-full h-48 object-cover">
                                                <div class="p-5">
                                                    <span id="edit-tanggal-{{ $berita->id }}" class="text-xs text-green-600 font-medium">{{ $berita->tanggal->format('d M Y') }}</span>
                                                    <h3 id="edit-judul-{{ $berita->id }}" class="font-bold text-gray-900 mt-2 mb-2">{{ $berita->judul }}</h3>
                                                    <p id="edit-deskripsi-{{ $berita->id }}" class="text-gray-600 text-sm mb-4">{{ Str::limit($berita->deskripsi, 100) }}</p>
                                                    <span class="text-green-600 text-sm font-medium">Baca Selengkapnya →</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    @endforeach
@endsection