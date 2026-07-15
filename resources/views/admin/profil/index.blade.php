@extends('layouts.admin')

@section('title', 'Profil - Admin Madinah El-Quds')
@section('page-title', 'Profil')

@section('content')
<div class="space-y-6">
    <!-- Informasi Umum -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informasi Umum
        </h3>
        @if($profil)
        <form action="{{ route('admin.profil.update', $profil) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
        @else
        <form action="{{ route('admin.profil.store') }}" method="POST" class="space-y-4">
            @csrf
        @endif
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pondok Pesantren</label>
                <input type="text" name="nama_pondok" value="{{ $profil->nama_pondok ?? 'Pondok Pesantren Madinah El-Quds' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengasuh Pesantren</label>
                    <input type="text" name="pengasuh" value="{{ $profil->pengasuh ?? 'KH. Ahmad Muhammad' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Berdiri</label>
                    <input type="text" name="tahun_berdiri" value="{{ $profil->tahun_berdiri ?? '2010' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Santri</label>
                    <input type="number" name="jumlah_santri" value="{{ $profil->jumlah_santri ?? '500' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Ustadz/Ustadzah</label>
                    <input type="number" name="jumlah_ustadz" value="{{ $profil->jumlah_ustadz ?? '45' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
    </div>

    <!-- Informasi Kontak -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            Informasi Kontak
        </h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $profil->alamat ?? 'Jl. Pendidikan No. 123, Kota Bandung, Jawa Barat 40123' }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                    <input type="text" name="telepon" value="{{ $profil->telepon ?? '(022) 1234-5678' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $profil->email ?? 'info@madinahelquds.sch.id' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="text" name="website" value="{{ $profil->website ?? 'www.madinahelquds.sch.id' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
        </div>
    </div>

    <!-- Visi & Misi -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Visi & Misi</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Visi Pesantren</label>
                <textarea name="visi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $profil->visi ?? 'Menjadi pondok pesantren modern yang unggul dalam ilmu agama dan sains, serta melahirkan generasi yang berakhlak mulia.' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Misi Pesantren</label>
                <textarea name="misi" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $profil->misi ?? '1. Menyelenggarakan pendidikan islam yang berkualitas
2. Mengintegrasikan ilmu agama dan sains modern
3. Membentuk santri yang berakhlaqul karimah
4. Mengembangkan potensi santri secara optimal' }}</textarea>
            </div>
        </div>
    </div>

    <!-- Sejarah Pesantren -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Sejarah Pesantren</h3>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sejarah Singkat</label>
            <textarea name="sejarah" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $profil->sejarah ?? 'Pondok Pesantren Madinah El-Quds didirikan pada tahun 2010 dengan visi untuk mencetak generasi muslim yang kuat dalam ilmu agama dan sains. Berawal dari 50 santri, kini telah berkembang menjadi pesantren dengan lebih dari 500 santri dari berbagai daerah di Indonesia.' }}</textarea>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        @if($profil)
        <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-[#1e3d2a] transition">
            Simpan Perubahan
        </button>
        </form>
        @else
        <button type="submit" class="bg-[#2d5a3d] text-white px-6 py-2 rounded-lg hover:bg-[#1e3d2a] transition">
            Simpan Profil
        </button>
        </form>
        @endif
    </div>
</div>
@endsection
