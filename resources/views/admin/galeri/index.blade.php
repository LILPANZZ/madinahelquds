@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('page-title', 'Galeri')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <!-- Form Tambah Galeri -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-1">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Foto ke Galeri
        </h3>

        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Foto</label>
                <input type="text" name="judul" id="prev-judul" value="{{ old('judul') }}"
                    placeholder="Masukkan judul foto"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('judul') border-red-500 @enderror"
                    oninput="updatePreview()">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="prev-deskripsi" rows="3"
                    placeholder="Masukkan deskripsi foto"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('deskripsi') border-red-500 @enderror"
                    oninput="updatePreview()">{{ old('deskripsi') }}</textarea>
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
            <div class="flex gap-3">
                <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">Simpan ke Galeri</button>
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
            Preview Tampilan Publik (Galeri)
        </h3>
        <div class="border-2 border-dashed border-gray-200 rounded-xl p-1">
            <!-- Simulasi tampilan galeri grid di halaman publik -->
            <div class="relative group overflow-hidden rounded-xl aspect-square max-w-xs mx-auto">
                <img id="preview-img-new" src="https://placehold.co/400x400/e5e7eb/9ca3af?text=Foto+Galeri" alt="preview" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/90 to-transparent flex items-end p-4">
                    <div>
                        <span id="preview-judul-text" class="text-white text-sm font-medium block">Judul Foto</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Galeri -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Foto Galeri</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($galeris as $galeri)
                <div class="relative group rounded-lg overflow-hidden shadow-sm border">
                    <img src="{{ '/storage/' . (is_array($galeri->gambar) && count($galeri->gambar) > 0 ? $galeri->gambar[0] : $galeri->gambar) }}" alt="{{ $galeri->judul }}" class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="flex gap-2">
                            <button onclick="editGaleri({{ $galeri->id }})" class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form action="{{ route('admin.galeri.destroy', $galeri) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-3">
                        <h4 class="text-white font-medium text-sm truncate">{{ $galeri->judul }}</h4>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p>Belum ada foto di galeri. Silakan tambah foto baru.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $galeris->links() }}</div>
    </div>
</div>


@endsection

@section('scripts')
<script>
function updatePreview() {
    const judul = document.getElementById('prev-judul').value || 'Judul Foto';
    document.getElementById('preview-judul-text').textContent = judul;
}

function resetPreview() {
    document.getElementById('preview-img-new').src = 'https://placehold.co/400x400/e5e7eb/9ca3af?text=Foto+Galeri';
    document.getElementById('preview-judul-text').textContent = 'Judul Foto';
}

function previewImage(input, targetId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById(targetId).src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

function updateEditPreview(id, field, value) {
    if (field === 'judul') document.getElementById('edit-judul-' + id).textContent = value || 'Judul Foto';
}

function editGaleri(id) {
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
</script>

    <!-- Edit Modals -->
    @foreach($galeris as $galeri)


                <!-- Edit Modal dengan Preview -->
                <div id="edit-modal-{{ $galeri->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Edit Foto Galeri</h3>
                            <button onclick="closeEditModal({{ $galeri->id }})" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Foto</label>
                                    <input type="text" name="judul" value="{{ $galeri->judul }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                        oninput="updateEditPreview({{ $galeri->id }}, 'judul', this.value)">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">{{ $galeri->deskripsi }}</textarea>
                                </div>
                                <div>
                                    @php
                                        $rawImages = is_array($galeri->gambar) ? $galeri->gambar : (is_string($galeri->gambar) && $galeri->gambar ? [$galeri->gambar] : []);
                                        $images = array_values(array_filter($rawImages, fn($img) => !empty($img)));
                                    @endphp
                                    @if(count($images) > 0)
                                    <div class="mb-3 mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach($images as $img)
                                                <div class="relative w-20 h-20 rounded border border-gray-200 overflow-hidden shadow-sm group img-item">
                                                    <img src="{{ '/storage/' . $img }}" class="w-full h-full object-cover">
                                                    <button type="button" onclick="removeImage('{{ $img }}', this)" style="position: absolute; top: 4px; right: 4px; z-index: 50; background-color: #ef4444; color: white; border-radius: 9999px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; cursor: pointer; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);" title="Hapus foto ini">X</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Baru (Opsional) <button type="button" onclick="addFileInput('edit-image-container-{{ $galeri->id }}', 'gambar[]', 'edit-img-{{ $galeri->id }}')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="edit-image-container-{{ $galeri->id }}" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="gambar[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'edit-img-{{ $galeri->id }}')">
    </div>
</div>
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah</p>
                                </div>
                                <div class="flex gap-3 pt-2">
                                    <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-green-800 transition">Update Foto</button>
                                    <button type="button" onclick="closeEditModal({{ $galeri->id }})" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition">Batal</button>
                                </div>
                            </form>

                            <!-- Preview Edit -->
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-3 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Preview Tampilan Publik
                                </p>
                                <div class="border-2 border-dashed border-gray-200 rounded-xl p-2">
                                    <div class="relative group overflow-hidden rounded-xl aspect-square">
                                        <img id="edit-img-{{ $galeri->id }}" src="{{ '/storage/' . (is_array($galeri->gambar) && count($galeri->gambar) > 0 ? $galeri->gambar[0] : $galeri->gambar) }}" alt="preview" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/90 to-transparent flex items-end p-4">
                                            <div>
                                                <span id="edit-judul-{{ $galeri->id }}" class="text-white text-sm font-medium block">{{ $galeri->judul }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    @endforeach
@endsection