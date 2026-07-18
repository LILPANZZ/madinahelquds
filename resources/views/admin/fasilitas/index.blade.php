@extends('layouts.admin')

@section('title', 'Fasilitas - Admin Madinah El-Quds')
@section('page-title', 'Fasilitas')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <!-- Form Tambah Fasilitas -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-1">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Fasilitas Baru
        </h3>

        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Fasilitas</label>
                    <input type="text" name="nama" id="prev-nama" oninput="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" id="prev-kategori" onchange="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Sosial">Sosial</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah/Kapasitas</label>
                    <input type="text" name="jumlah_kapasitas" id="prev-kapasitas" oninput="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="prev-deskripsi" rows="3" oninput="updatePreview()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto <button type="button" onclick="addFileInput('add-image-container', 'gambar[]', 'preview-img-new')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="add-image-container" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="gambar[]" accept="image/*" required
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'preview-img-new')">
    </div>
</div>
                    <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-[#2d5a3d] text-white px-4 py-2 rounded-lg hover:bg-[#1e3d2a] transition">Simpan Fasilitas</button>
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
            <div class="text-center group block max-w-xs mx-auto">
                <div class="rounded-xl overflow-hidden shadow-lg mb-4">
                    <img id="preview-img-new" src="https://placehold.co/400x224/e5e7eb/9ca3af?text=Foto+Fasilitas" alt="preview" class="w-full h-56 object-cover">
                </div>
                <h4 id="preview-nama-text" class="font-bold text-gray-900 text-lg">Nama Fasilitas</h4>
                <p id="preview-kapasitas-text" class="text-gray-600 text-sm mt-1">Kapasitas</p>
                <p id="preview-deskripsi-text" class="text-gray-600 text-sm mt-1">Deskripsi fasilitas...</p>
                <span id="preview-kategori-badge" class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">Kategori</span>
            </div>
        </div>
    </div>

    <!-- Daftar Fasilitas -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6 order-3">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Fasilitas</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($fasilitas as $item)
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="w-full h-32 overflow-hidden">
                    <img src="{{ asset('storage/' . (is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : $item->gambar)) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded mb-2">{{ $item->kategori }}</span>
                    <h4 class="font-semibold text-gray-800">{{ $item->nama }}</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ $item->jumlah_kapasitas }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($item->deskripsi, 80) }}</p>
                    <div class="flex gap-2 mt-3">
                        <button onclick="openEditModal({{ $item->id }})" class="flex-1 bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition">Edit</button>
                        <form action="{{ route('admin.fasilitas.destroy', $item) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">Belum ada fasilitas yang ditambahkan.</div>
            @endforelse
        </div>
    </div>
</div>

    <!-- Edit Modals -->
    @foreach($fasilitas as $item)


            <!-- Edit Modal dengan Preview -->
            <div id="editModal-{{ $item->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Edit Fasilitas</h3>
                        <button onclick="closeEditModal({{ $item->id }})" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <form action="{{ route('admin.fasilitas.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Fasilitas</label>
                                    <input type="text" name="nama" value="{{ $item->nama }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $item->id }}, 'nama', this.value)" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                    <select name="kategori"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        onchange="updateEditPreview({{ $item->id }}, 'kategori', this.value)" required>
                                        <option value="Akademik" {{ $item->kategori == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="Olahraga" {{ $item->kategori == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                        <option value="Sosial" {{ $item->kategori == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                        <option value="Lainnya" {{ $item->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah/Kapasitas</label>
                                    <input type="text" name="jumlah_kapasitas" value="{{ $item->jumlah_kapasitas }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $item->id }}, 'kapasitas', this.value)" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $item->id }}, 'deskripsi', this.value)" required>{{ $item->deskripsi }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    @php
                                        $rawImages = is_array($item->gambar) ? $item->gambar : (is_string($item->gambar) && $item->gambar ? [$item->gambar] : []);
                                        $images = array_values(array_filter($rawImages, fn($img) => !empty($img)));
                                    @endphp
                                    @if(count($images) > 0)
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach($images as $img)
                                                <div class="relative w-20 h-20 rounded border border-gray-200 overflow-hidden shadow-sm group img-item">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                                    <button type="button" onclick="removeImage('{{ $img }}', this)" style="position: absolute; top: 4px; right: 4px; z-index: 50; background-color: #ef4444; color: white; border-radius: 9999px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; cursor: pointer; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);" title="Hapus gambar ini">X</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (Opsional) <button type="button" onclick="addFileInput('edit-image-container-{{ $item->id }}', 'gambar[]', 'edit-img-{{ $item->id }}')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="edit-image-container-{{ $item->id }}" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="gambar[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'edit-img-{{ $item->id }}')">
    </div>
</div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeEditModal({{ $item->id }})" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">Batal</button>
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
                                <div class="text-center group block">
                                    <div class="rounded-xl overflow-hidden shadow-lg mb-4">
                                        <img id="edit-img-{{ $item->id }}" src="{{ asset('storage/' . (is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : $item->gambar)) }}" alt="preview" class="w-full h-48 object-cover">
                                    </div>
                                    <h4 id="edit-nama-{{ $item->id }}" class="font-bold text-gray-900 text-lg">{{ $item->nama }}</h4>
                                    <p id="edit-kapasitas-{{ $item->id }}" class="text-gray-600 text-sm mt-1">{{ $item->jumlah_kapasitas }}</p>
                                    <p id="edit-deskripsi-{{ $item->id }}" class="text-gray-600 text-sm mt-1">{{ Str::limit($item->deskripsi, 80) }}</p>
                                    <span id="edit-kategori-{{ $item->id }}" class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">{{ $item->kategori }}</span>
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
    const nama = document.getElementById('prev-nama').value || 'Nama Fasilitas';
    const kategori = document.getElementById('prev-kategori').value || 'Kategori';
    const kapasitas = document.getElementById('prev-kapasitas').value || 'Kapasitas';
    const deskripsi = document.getElementById('prev-deskripsi').value || 'Deskripsi fasilitas...';
    document.getElementById('preview-nama-text').textContent = nama;
    document.getElementById('preview-kategori-badge').textContent = kategori;
    document.getElementById('preview-kapasitas-text').textContent = kapasitas;
    document.getElementById('preview-deskripsi-text').textContent = deskripsi.substring(0, 80) + (deskripsi.length > 80 ? '...' : '');
}

function resetPreview() {
    document.getElementById('preview-img-new').src = 'https://placehold.co/400x224/e5e7eb/9ca3af?text=Foto+Fasilitas';
    document.getElementById('preview-nama-text').textContent = 'Nama Fasilitas';
    document.getElementById('preview-kategori-badge').textContent = 'Kategori';
    document.getElementById('preview-kapasitas-text').textContent = 'Kapasitas';
    document.getElementById('preview-deskripsi-text').textContent = 'Deskripsi fasilitas...';
}

function previewImage(input, targetId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById(targetId).src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

function updateEditPreview(id, field, value) {
    if (field === 'nama') document.getElementById('edit-nama-' + id).textContent = value || 'Nama Fasilitas';
    if (field === 'kategori') document.getElementById('edit-kategori-' + id).textContent = value || 'Kategori';
    if (field === 'kapasitas') document.getElementById('edit-kapasitas-' + id).textContent = value || 'Kapasitas';
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
    @foreach($fasilitas as $item)


            <!-- Edit Modal dengan Preview -->
            <div id="editModal-{{ $item->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Edit Fasilitas</h3>
                        <button onclick="closeEditModal({{ $item->id }})" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <form action="{{ route('admin.fasilitas.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Fasilitas</label>
                                    <input type="text" name="nama" value="{{ $item->nama }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $item->id }}, 'nama', this.value)" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                    <select name="kategori"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        onchange="updateEditPreview({{ $item->id }}, 'kategori', this.value)" required>
                                        <option value="Akademik" {{ $item->kategori == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="Olahraga" {{ $item->kategori == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                        <option value="Sosial" {{ $item->kategori == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                        <option value="Lainnya" {{ $item->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah/Kapasitas</label>
                                    <input type="text" name="jumlah_kapasitas" value="{{ $item->jumlah_kapasitas }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $item->id }}, 'kapasitas', this.value)" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        oninput="updateEditPreview({{ $item->id }}, 'deskripsi', this.value)" required>{{ $item->deskripsi }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar (Opsional) <button type="button" onclick="addFileInput('edit-image-container-{{ $item->id }}', 'gambar[]', 'edit-img-{{ $item->id }}')" class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">+ Tambah Foto</button></label>
<div id="edit-image-container-{{ $item->id }}" class="space-y-2">
    <div class="flex items-center gap-2">
        <img src="" class="w-10 h-10 hidden object-cover rounded shadow-sm border border-gray-200">
        <input type="file" name="gambar[]" accept="image/*"
            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
            onchange="previewMulti(this, 'edit-img-{{ $item->id }}')">
    </div>
</div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeEditModal({{ $item->id }})" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">Batal</button>
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
                                <div class="text-center group block">
                                    <div class="rounded-xl overflow-hidden shadow-lg mb-4">
                                        <img id="edit-img-{{ $item->id }}" src="{{ asset('storage/' . (is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : $item->gambar)) }}" alt="preview" class="w-full h-48 object-cover">
                                    </div>
                                    <h4 id="edit-nama-{{ $item->id }}" class="font-bold text-gray-900 text-lg">{{ $item->nama }}</h4>
                                    <p id="edit-kapasitas-{{ $item->id }}" class="text-gray-600 text-sm mt-1">{{ $item->jumlah_kapasitas }}</p>
                                    <p id="edit-deskripsi-{{ $item->id }}" class="text-gray-600 text-sm mt-1">{{ Str::limit($item->deskripsi, 80) }}</p>
                                    <span id="edit-kategori-{{ $item->id }}" class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">{{ $item->kategori }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
@endsection