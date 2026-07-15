@extends('layouts.admin')

@section('title', 'Kelola Komentar - Admin Madinah El-Quds')
@section('page-title', 'Kelola Komentar')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Daftar Semua Komentar</h3>
                <p class="text-sm text-gray-500">Total: {{ $allKomentars->total() }} komentar</p>
            </div>
        </div>
        <!-- Statistik badge -->
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-sm font-medium px-3 py-1.5 rounded-full border border-blue-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                {{ $allKomentars->total() }} Komentar
            </span>
        </div>
    </div>

    <!-- Tabel Komentar -->
    @if($allKomentars->count() > 0)
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-8">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengirim</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Isi Komentar</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Berita</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($allKomentars as $index => $komentar)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <!-- Nomor -->
                    <td class="px-4 py-4 text-sm text-gray-400 font-medium">
                        {{ $allKomentars->firstItem() + $index }}
                    </td>

                    <!-- Pengirim -->
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ strtoupper(substr($komentar->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $komentar->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $komentar->email }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Isi Komentar -->
                    <td class="px-4 py-4">
                        <div class="max-w-xs">
                            @if($komentar->parent_id)
                                <div class="flex items-start gap-1 mb-1">
                                    <svg class="w-3 h-3 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                    </svg>
                                    <span class="text-xs text-gray-400">Membalas: <span class="font-medium">{{ $komentar->parent->nama ?? 'komentar dihapus' }}</span></span>
                                </div>
                            @endif
                            <p class="text-sm text-gray-700 leading-relaxed">
                                {{ Str::limit($komentar->komentar, 120) }}
                            </p>
                            @if(strlen($komentar->komentar) > 120)
                                <button onclick="showFullKomentar({{ $komentar->id }})" class="text-xs text-blue-600 hover:text-blue-800 mt-1 font-medium">
                                    Lihat selengkapnya
                                </button>
                                <!-- Modal isi komentar penuh -->
                                <div id="modalKomentar-{{ $komentar->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                                    <div class="bg-white rounded-xl p-6 max-w-lg w-full mx-4 shadow-xl">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-sm font-bold">
                                                    {{ strtoupper(substr($komentar->nama, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">{{ $komentar->nama }}</p>
                                                    <p class="text-xs text-gray-500">{{ $komentar->email }}</p>
                                                </div>
                                            </div>
                                            <button onclick="hideFullKomentar({{ $komentar->id }})" class="text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $komentar->komentar }}</p>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-3">Dikirim pada: {{ $komentar->created_at->format('d M Y, H:i') }} WIB</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </td>

                    <!-- Berita -->
                    <td class="px-4 py-4">
                        @if($komentar->berita)
                            <div class="max-w-[180px]">
                                <a href="{{ route('berita.detail', $komentar->berita->judul) }}" target="_blank"
                                   class="text-sm text-blue-600 hover:text-blue-800 hover:underline font-medium leading-snug">
                                    {{ Str::limit($komentar->berita->judul, 50) }}
                                </a>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $komentar->berita->tanggal->format('d M Y') }}</p>
                            </div>
                        @else
                            <span class="text-xs text-gray-400 italic">Berita tidak ditemukan</span>
                        @endif
                    </td>

                    <!-- Jenis -->
                    <td class="px-4 py-4">
                        @if($komentar->parent_id)
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Balasan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                Utama
                            </span>
                        @endif
                    </td>

                    <!-- Tanggal -->
                    <td class="px-4 py-4">
                        <p class="text-sm text-gray-600">{{ $komentar->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $komentar->created_at->format('H:i') }} WIB</p>
                    </td>

                    <!-- Aksi -->
                    <td class="px-4 py-4 text-center">
                        <form action="{{ route('admin.komentar.destroy', $komentar) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?\n\nKomentar dari: {{ $komentar->nama }}\nBalasan yang terhubung juga akan ikut dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1.5 text-red-600 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 text-xs font-medium px-3 py-1.5 rounded-lg transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    @if($allKomentars->hasPages())
    <div class="mt-4 flex justify-between items-center">
        <p class="text-sm text-gray-500">
            Menampilkan {{ $allKomentars->firstItem() }}–{{ $allKomentars->lastItem() }} dari {{ $allKomentars->total() }} komentar
        </p>
        <div class="flex gap-1">
            {{ $allKomentars->links() }}
        </div>
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-600 mb-1">Belum Ada Komentar</h4>
        <p class="text-sm text-gray-400">Komentar dari pengunjung berita akan tampil di sini.</p>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function showFullKomentar(id) {
    const modal = document.getElementById('modalKomentar-' + id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function hideFullKomentar(id) {
    const modal = document.getElementById('modalKomentar-' + id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Tutup modal saat klik di luar
document.addEventListener('click', function(e) {
    const modals = document.querySelectorAll('[id^="modalKomentar-"]');
    modals.forEach(function(modal) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});
</script>
@endsection
