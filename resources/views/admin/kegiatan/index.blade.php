@extends('layouts.admin')

@section('title', 'Kegiatan Ekstrakurikuler - Admin Madinah El-Quds')
@section('page-title', 'Kegiatan Ekstrakurikuler')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <!-- Form Tambah Kegiatan -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-1">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kegiatan Ekstrakurikuler Baru
        </h3>

        <form action="{{ route('admin.kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kegiatan</label>
                    <input type="text" name="judul" id="prev-judul" oninput="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat</label>
                    <input type="text" name="tempat" id="prev-tempat" oninput="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="prev-deskripsi" rows="3" oninput="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto <button type="button" onclick="addFileInput('add-image-container', 'foto[]', 'preview-img-new')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="add-image-container" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="foto[]" accept="image/*" required
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'preview-img-new')">
    </div>
</div>
                    <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-[#2d5a3d] text-white px-4 py-2 rounded-lg hover:bg-[#1e3d2a] transition">Simpan Kegiatan</button>
                <button type="reset" onclick="resetPreview()" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">Reset</button>
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
            <div class="flex gap-4 p-4 border border-gray-200 rounded-lg bg-white">
                <img id="preview-img-new" src="https://placehold.co/80x80/e5e7eb/9ca3af?text=Foto" alt="preview" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                <div class="flex-1">
                    <h4 id="preview-judul-text" class="font-semibold text-gray-800">Judul Kegiatan</h4>
                    <p class="text-sm text-gray-500 mt-1">

                        <span class="flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span id="preview-tempat-text">Tempat</span>
                        </span>
                    </p>
                    <p id="preview-deskripsi-text" class="text-sm text-gray-600 mt-2">Deskripsi kegiatan...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Kegiatan -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Kegiatan Ekstrakurikuler</h3>
        <div class="space-y-4">
            @forelse($kegiatans as $kegiatan)
            <div class="flex gap-4 p-4 border border-gray-200 rounded-lg">
                <img src="{{ asset('storage/' . (is_array($kegiatan->foto) && count($kegiatan->foto) > 0 ? $kegiatan->foto[0] : $kegiatan->foto)) }}" alt="{{ $kegiatan->judul }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $kegiatan->judul }}</h4>
                            <p class="text-sm text-gray-500 mt-1">

                                <span class="flex items-center gap-1 mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $kegiatan->tempat }}
                                </span>
                            </p>
                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($kegiatan->deskripsi, 100) }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openEditModal({{ $kegiatan->id }})" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('admin.kegiatan.destroy', $kegiatan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">Belum ada kegiatan yang ditambahkan.</div>
            @endforelse
        </div>
    </div>
</div>

    <!-- Edit Modals -->
    @foreach($kegiatans as $kegiatan)


            <!-- Edit Modal dengan Preview -->
            <div id="editModal-{{ $kegiatan->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Edit Kegiatan</h3>
                        <button onclick="closeEditModal({{ $kegiatan->id }})" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                                    <input type="text" name="judul" value="{{ $kegiatan->judul }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $kegiatan->id }}, 'judul', this.value)" required>
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat</label>
                                    <input type="text" name="tempat" value="{{ $kegiatan->tempat }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $kegiatan->id }}, 'tempat', this.value)" required>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $kegiatan->id }}, 'deskripsi', this.value)" required>{{ $kegiatan->deskripsi }}</textarea>
                                </div>
                                <div class="col-span-2">
                                    @php
                                        $rawImages = is_array($kegiatan->foto) ? $kegiatan->foto : (is_string($kegiatan->foto) && $kegiatan->foto ? [$kegiatan->foto] : []);
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

                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto (Opsional) <button type="button" onclick="addFileInput('edit-image-container-{{ $kegiatan->id }}', 'foto[]', 'edit-img-{{ $kegiatan->id }}')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="edit-image-container-{{ $kegiatan->id }}" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="foto[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'edit-img-{{ $kegiatan->id }}')">
    </div>
</div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeEditModal({{ $kegiatan->id }})" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">Batal</button>
                                <button type="submit" class="bg-[#2d5a3d] text-white px-4 py-2 rounded-lg hover:bg-[#1e3d2a] transition">Simpan Perubahan</button>
                            </div>
                        </form>

                        <!-- Preview Edit -->
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview Tampilan Publik
                            </p>
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-2">
                                <div class="flex gap-4 p-4 border border-gray-200 rounded-lg bg-white">
                                    <img id="edit-img-{{ $kegiatan->id }}" src="{{ asset('storage/' . (is_array($kegiatan->foto) && count($kegiatan->foto) > 0 ? $kegiatan->foto[0] : $kegiatan->foto)) }}" alt="preview" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                    <div class="flex-1">
                                        <h4 id="edit-judul-{{ $kegiatan->id }}" class="font-semibold text-gray-800">{{ $kegiatan->judul }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">

                                            <span class="flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                <span id="edit-tempat-{{ $kegiatan->id }}">{{ $kegiatan->tempat }}</span>
                                            </span>
                                        </p>
                                        <p id="edit-deskripsi-{{ $kegiatan->id }}" class="text-sm text-gray-600 mt-2">{{ Str::limit($kegiatan->deskripsi, 80) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
@endsection

@section('scripts')
<script>
function updatePreview() {
    const judul = document.getElementById('prev-judul').value || 'Judul Kegiatan';
    const tempat = document.getElementById('prev-tempat').value || 'Tempat';
    const deskripsi = document.getElementById('prev-deskripsi').value || 'Deskripsi kegiatan...';

    document.getElementById('preview-judul-text').textContent = judul;
    document.getElementById('preview-tempat-text').textContent = tempat;
    document.getElementById('preview-deskripsi-text').textContent = deskripsi.substring(0, 80) + (deskripsi.length > 80 ? '...' : '');
}

function resetPreview() {
    document.getElementById('preview-img-new').src = 'https://placehold.co/80x80/e5e7eb/9ca3af?text=Foto';
    document.getElementById('preview-judul-text').textContent = 'Judul Kegiatan';
    document.getElementById('preview-tempat-text').textContent = 'Tempat';
    document.getElementById('preview-deskripsi-text').textContent = 'Deskripsi kegiatan...';
}

function previewImage(input, targetId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById(targetId).src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

function updateEditPreview(id, field, value) {
    if (field === 'judul') document.getElementById('edit-judul-' + id).textContent = value || 'Judul Kegiatan';
    if (field === 'tempat') document.getElementById('edit-tempat-' + id).textContent = value || 'Tempat';
    if (field === 'deskripsi') document.getElementById('edit-deskripsi-' + id).textContent = (value || '').substring(0, 80) + (value.length > 80 ? '...' : '');
}



function openEditModal(id) {
    const modal = document.getElementById('editModal-' + id);
    
    // Reset state gambar yang dihapus jika sebelumnya dibatalkan
    modal.querySelectorAll('.img-item').forEach(el => el.style.display = '');
    modal.querySelectorAll('input[name="delete_gambar[]"]').forEach(el => el.remove());
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal(id) {
    document.getElementById('editModal-' + id).classList.add('hidden');
    document.getElementById('editModal-' + id).classList.remove('flex');
}
</script>

    <!-- Edit Modals -->
    @foreach($kegiatans as $kegiatan)


            <!-- Edit Modal dengan Preview -->
            <div id="editModal-{{ $kegiatan->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Edit Kegiatan</h3>
                        <button onclick="closeEditModal({{ $kegiatan->id }})" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                                    <input type="text" name="judul" value="{{ $kegiatan->judul }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $kegiatan->id }}, 'judul', this.value)" required>
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat</label>
                                    <input type="text" name="tempat" value="{{ $kegiatan->tempat }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $kegiatan->id }}, 'tempat', this.value)" required>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $kegiatan->id }}, 'deskripsi', this.value)" required>{{ $kegiatan->deskripsi }}</textarea>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto (Opsional) <button type="button" onclick="addFileInput('edit-image-container-{{ $kegiatan->id }}', 'foto[]', 'edit-img-{{ $kegiatan->id }}')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="edit-image-container-{{ $kegiatan->id }}" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="foto[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'edit-img-{{ $kegiatan->id }}')">
    </div>
</div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeEditModal({{ $kegiatan->id }})" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">Batal</button>
                                <button type="submit" class="bg-[#2d5a3d] text-white px-4 py-2 rounded-lg hover:bg-[#1e3d2a] transition">Simpan Perubahan</button>
                            </div>
                        </form>

                        <!-- Preview Edit -->
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview Tampilan Publik
                            </p>
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-2">
                                <div class="flex gap-4 p-4 border border-gray-200 rounded-lg bg-white">
                                    <img id="edit-img-{{ $kegiatan->id }}" src="{{ asset('storage/' . (is_array($kegiatan->foto) && count($kegiatan->foto) > 0 ? $kegiatan->foto[0] : $kegiatan->foto)) }}" alt="preview" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                                    <div class="flex-1">
                                        <h4 id="edit-judul-{{ $kegiatan->id }}" class="font-semibold text-gray-800">{{ $kegiatan->judul }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">

                                            <span class="flex items-center gap-1 mt-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                <span id="edit-tempat-{{ $kegiatan->id }}">{{ $kegiatan->tempat }}</span>
                                            </span>
                                        </p>
                                        <p id="edit-deskripsi-{{ $kegiatan->id }}" class="text-sm text-gray-600 mt-2">{{ Str::limit($kegiatan->deskripsi, 80) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
@endsection