@extends('layouts.admin')

@section('title', 'Kelola Prestasi')
@section('page-title', 'Prestasi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <!-- Form Tambah Prestasi -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-1">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Prestasi Baru
        </h3>

        <form action="{{ route('admin.prestasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="form-prestasi">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Prestasi</label>
                <input type="text" name="judul_prestasi" id="prev-judul" value="{{ old('judul_prestasi') }}"
                    placeholder="Masukkan judul prestasi"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('judul_prestasi') border-red-500 @enderror"
                    oninput="updatePreview()">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <input type="text" name="kategori" id="prev-kategori" value="{{ old('kategori') }}"
                    placeholder="Contoh: Akademik, Olahraga"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('kategori') border-red-500 @enderror"
                    oninput="updatePreview()">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="prev-deskripsi" rows="4"
                    placeholder="Masukkan deskripsi prestasi"
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
                <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">
                    Simpan Prestasi
                </button>
                <button type="reset" onclick="resetPreview()" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition">
                    Batal
                </button>
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
                <img id="preview-img-new" src="https://placehold.co/600x300/e5e7eb/9ca3af?text=Gambar+Prestasi" alt="preview" class="w-full h-48 object-cover">
                <div class="p-5">
                    <span id="preview-kategori-badge" class="text-xs font-medium px-2 py-1 bg-green-100 text-green-700 rounded-full">Kategori</span>
                    <h3 id="preview-judul-text" class="font-bold text-gray-900 mt-3 mb-2 text-lg">Judul Prestasi</h3>
                    <p id="preview-deskripsi-text" class="text-gray-600 text-sm mb-3">Deskripsi prestasi akan tampil di sini...</p>
                    <span id="preview-tanggal-text" class="text-xs text-gray-400"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Prestasi -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Prestasi</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Gambar</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Judul</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Kategori</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-700">Tanggal</th>
                        <th class="text-center py-3 px-4 text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestasis as $prestasi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <img src="{{ asset('storage/' . (is_array($prestasi->gambar) && count($prestasi->gambar) > 0 ? $prestasi->gambar[0] : $prestasi->gambar)) }}" alt="{{ $prestasi->judul_prestasi }}" class="w-20 h-14 object-cover rounded">
                            </td>
                            <td class="py-3 px-4">
                                <p class="font-medium text-gray-800">{{ $prestasi->judul_prestasi }}</p>
                                <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit(strip_tags($prestasi->deskripsi), 100) }}</p>
                            </td>
                            <td class="py-3 px-4 text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $prestasi->kategori }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ $prestasi->tanggal->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex justify-center gap-2">
                                    <button onclick="editPrestasi({{ $prestasi->id }})" class="text-blue-500 hover:text-blue-700 p-1" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.prestasi.destroy', $prestasi) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus prestasi ini?')">
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
                            <td colspan="5" class="py-8 text-center text-gray-500">Belum ada prestasi. Silakan tambah prestasi baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $prestasis->links() }}</div>
    </div>
</div>


@endsection

@section('scripts')
<script>
function updatePreview() {
    const judul = document.getElementById('prev-judul').value || 'Judul Prestasi';
    const kategori = document.getElementById('prev-kategori').value || 'Kategori';
    const deskripsi = document.getElementById('prev-deskripsi').value || 'Deskripsi prestasi akan tampil di sini...';
    const tanggal = document.getElementById('prev-tanggal').value;

    document.getElementById('preview-judul-text').textContent = judul;
    document.getElementById('preview-kategori-badge').textContent = kategori;
    document.getElementById('preview-deskripsi-text').textContent = deskripsi.substring(0, 100) + (deskripsi.length > 100 ? '...' : '');
    if (tanggal) {
        const d = new Date(tanggal);
        document.getElementById('preview-tanggal-text').textContent = d.toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'});
    }
}

function resetPreview() {
    document.getElementById('preview-img-new').src = 'https://placehold.co/600x300/e5e7eb/9ca3af?text=Gambar+Prestasi';
    document.getElementById('preview-judul-text').textContent = 'Judul Prestasi';
    document.getElementById('preview-kategori-badge').textContent = 'Kategori';
    document.getElementById('preview-deskripsi-text').textContent = 'Deskripsi prestasi akan tampil di sini...';
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
    if (field === 'judul') document.getElementById('edit-judul-' + id).textContent = value || 'Judul Prestasi';
    if (field === 'kategori') document.getElementById('edit-kategori-' + id).textContent = value || 'Kategori';
    if (field === 'deskripsi') document.getElementById('edit-deskripsi-' + id).textContent = (value || '').substring(0, 100) + (value.length > 100 ? '...' : '');
    if (field === 'tanggal' && value) {
        const d = new Date(value);
        document.getElementById('edit-tanggal-' + id).textContent = d.toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'});
    }
}

function editPrestasi(id) {
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

// Init tanggal preview
updatePreview();
</script>

    <!-- Edit Modals -->
    @foreach($prestasis as $prestasi)


                        <!-- Edit Modal dengan Preview -->
                        <div id="edit-modal-{{ $prestasi->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-lg p-6 w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">Edit Prestasi</h3>
                                    <button onclick="closeEditModal({{ $prestasi->id }})" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Form Edit -->
                                    <form action="{{ route('admin.prestasi.update', $prestasi) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Prestasi</label>
                                            <input type="text" name="judul_prestasi" value="{{ $prestasi->judul_prestasi }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                                oninput="updateEditPreview({{ $prestasi->id }}, 'judul', this.value)">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                            <input type="text" name="kategori" value="{{ $prestasi->kategori }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                                oninput="updateEditPreview({{ $prestasi->id }}, 'kategori', this.value)">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                            <textarea name="deskripsi" rows="4"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                                oninput="updateEditPreview({{ $prestasi->id }}, 'deskripsi', this.value)">{{ $prestasi->deskripsi }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                                <input type="date" name="tanggal" value="{{ $prestasi->tanggal->format('Y-m-d') }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                                    oninput="updateEditPreview({{ $prestasi->id }}, 'tanggal', this.value)">
                                            </div>
                                            <div>
                                                @php
                                                    $rawImages = is_array($prestasi->gambar) ? $prestasi->gambar : (is_string($prestasi->gambar) && $prestasi->gambar ? [$prestasi->gambar] : []);
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

                                                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Baru (Opsional) <button type="button" onclick="addFileInput('edit-image-container-{{ $prestasi->id }}', 'gambar[]', 'edit-img-{{ $prestasi->id }}')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="edit-image-container-{{ $prestasi->id }}" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="gambar[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'edit-img-{{ $prestasi->id }}')">
    </div>
</div>
                                                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 pt-2">
                                            <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">Update Prestasi</button>
                                            <button type="button" onclick="closeEditModal({{ $prestasi->id }})" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition">Batal</button>
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
                                                <img id="edit-img-{{ $prestasi->id }}" src="{{ asset('storage/' . (is_array($prestasi->gambar) && count($prestasi->gambar) > 0 ? $prestasi->gambar[0] : $prestasi->gambar)) }}" alt="preview" class="w-full h-48 object-cover">
                                                <div class="p-5">
                                                    <span id="edit-kategori-{{ $prestasi->id }}" class="text-xs font-medium px-2 py-1 bg-green-100 text-green-700 rounded-full">{{ $prestasi->kategori }}</span>
                                                    <h3 id="edit-judul-{{ $prestasi->id }}" class="font-bold text-gray-900 mt-3 mb-2 text-lg">{{ $prestasi->judul_prestasi }}</h3>
                                                    <p id="edit-deskripsi-{{ $prestasi->id }}" class="text-gray-600 text-sm mb-3">{{ Str::limit($prestasi->deskripsi, 100) }}</p>
                                                    <span id="edit-tanggal-{{ $prestasi->id }}" class="text-xs text-gray-400">{{ $prestasi->tanggal->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    @endforeach
@endsection