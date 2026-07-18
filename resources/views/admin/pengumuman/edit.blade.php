@extends('layouts.admin')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.pengumuman.index') }}" class="text-gray-500 hover:text-gray-700 mr-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Pengumuman</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pengumuman.update', $pengumuman) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $pengumuman->judul) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Isi Pengumuman</label>
            <textarea name="isi" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>{{ old('isi', $pengumuman->isi) }}</textarea>
        </div>

        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Selesai (Opsional)</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai ? $pengumuman->tanggal_selesai->format('Y-m-d') : '') }}" min="{{ $pengumuman->tanggal_mulai->format('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    @foreach(App\Models\Pengumuman::KATEGORI as $key => $value)
                        <option value="{{ $key }}" {{ old('kategori', $pengumuman->kategori) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    @foreach(App\Models\Pengumuman::STATUS as $key => $value)
                        <option value="{{ $key }}" {{ old('status', $pengumuman->status) == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Lampiran (Opsional)</label>
            @if($pengumuman->lampiran)
                <div id="lampiran-container" class="mb-2 p-3 bg-gray-100 rounded-lg flex items-center justify-between relative group">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        <span class="text-sm text-gray-700">{{ basename($pengumuman->lampiran) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="text-green-600 text-sm hover:underline">Lihat</a>
                        <button type="button" onclick="document.getElementById('lampiran-container').style.display='none'; document.getElementById('delete-lampiran').value='1';" style="background-color: #ef4444; color: white; border-radius: 9999px; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; cursor: pointer; border: 1px solid white;" title="Hapus lampiran ini">X</button>
                    </div>
                </div>
                <input type="hidden" name="delete_lampiran" id="delete-lampiran" value="0">
            @endif
            <input type="file" name="lampiran" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
            <p class="text-xs text-gray-500 mt-1">Upload file baru untuk mengganti lampiran sebelumnya. Format: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max 5MB)</p>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.pengumuman.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Perbarui</button>
        </div>
    </form>
</div>
@endsection
