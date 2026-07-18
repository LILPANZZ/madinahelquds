@extends('layouts.public')

@section('title', 'Selamat Datang')

@section('styles')
<style>
    .hero-bg {
        background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(30,58,95,0.85)), url('{{ asset('storage/bg/bg.png') }}');
        background-size: cover;
        background-position: center;
    }
    .gallery-overlay {
        background: linear-gradient(to top, rgba(30,58,95,0.9) 0%, transparent 60%);
    }

    /* Lightbox styles */
    .lightbox-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.85);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        backdrop-filter: blur(4px);
    }
    .lightbox-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .lightbox-content {
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        transform: scale(0.9) translateY(20px);
        transition: transform 0.3s ease;
    }
    .lightbox-overlay.active .lightbox-content {
        transform: scale(1) translateY(0);
    }
    .lightbox-close {
        position: absolute;
        top: -12px;
        right: -12px;
        width: 36px;
        height: 36px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        transition: transform 0.2s ease;
        z-index: 10;
    }
    .lightbox-close:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section id="beranda" class="hero-bg h-[600px] flex flex-col items-center justify-center text-white text-center relative">
        <p class="text-base md:text-lg tracking-[0.4em] mb-3 uppercase font-medium">PESANTREN TAHFIDZ</p>
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold mb-2 tracking-wide">Madinah El - Quds</h1>
        <p class="text-base md:text-lg mb-10 text-gray-200">Sebokarang, Wates, Wates, Kulon Progo</p>
        <a href="#tentang" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-full transition font-medium text-sm">Pelajari Lebih Lanjut</a>
        <div class="absolute bottom-8 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7"/>
            </svg>
        </div>
    </section>

    <!-- Statistik Section -->
    @if($profil)
    <section class="relative z-10 -mt-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $profil->tahun_berdiri }}</h3>
                    <p class="text-gray-500 font-medium text-sm">Tahun Berdiri</p>
                </div>
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $profil->jumlah_santri }}+</h3>
                    <p class="text-gray-500 font-medium text-sm">Santri Aktif</p>
                </div>
                <div>
                    <h3 class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $profil->jumlah_ustadz }}+</h3>
                    <p class="text-gray-500 font-medium text-sm">Tenaga Pengajar</p>
                </div>
                <div class="px-2">
                    <h3 class="text-xl md:text-2xl font-bold text-green-600 mb-2">{{ $profil->pengasuh }}</h3>
                    <p class="text-gray-500 font-medium text-sm">Pengasuh</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Sejarah Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Sejarah {{ $profil ? $profil->nama_pondok : 'Madinah El-Quds' }}</h2>
                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                        @if($profil && $profil->sejarah)
                            {{ Str::limit(strip_tags($profil->sejarah), 350) }}
                        @else
                            Yayasan Madinah El-Quds merupakan pondok pesantren tahfidz al-quran yang berlokasi di Ds. Sebokarang Kec. Wates Kulon Progo dan dipimpin oleh Prof. Dr. KH. Nuruddin Ali Muhtarom. Pondok Pesantren ini mendidik generasi bangsa yang berakhlak mulia.
                        @endif
                    </p>
                    <a href="{{ route('tentang') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md text-sm transition text-center mt-4">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                <div class="rounded-lg overflow-hidden shadow-xl">
                    <img src="{{ asset('images/building.jpg') }}" alt="Gedung Madinah El-Quds" class="w-full h-[400px] object-cover" onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?w=600'">
                </div>
            </div>
        </div>
    </section>

    <!-- Program Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Tahfidz -->
                <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">Tahfidz Al-Quran bersanad</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>

                <!-- Card 2: Kitab Kuning -->
                <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-yellow-400 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">Kitab Kuning</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Sed do eiusmod tempor incididunt ut labore et dolore.</p>
                </div>

                <!-- Card 3: Bahasa Asing -->
                <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-pink-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">Bahasa Asing</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Ut enim ad minim veniam quis nostrud exercitation.</p>
                </div>

                <!-- Card 4: Literasi & IT -->
                <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">Literasi & IT</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Duis aute irure dolor in reprehenderit in voluptate.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Visi -->
                <div class="bg-[#1e3a5f] text-white rounded-xl p-8">
                    <h3 class="text-2xl font-bold mb-4">Visi</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Menjadi lembaga pendidikan Islam yang unggul dalam menghasilkan generasi Qur'ani yang berakhlak mulia, berilmu luas, dan berkemampuan teknologi untuk kemaslahatan umat.
                    </p>
                </div>
                <!-- Misi -->
                <div class="bg-[#1e3a5f] text-white rounded-xl p-8">
                    <h3 class="text-2xl font-bold mb-4">Misi</h3>
                    <ul class="space-y-3 text-gray-300 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            <span>Menyelenggarakan pendidikan tahfidz Al-Quran dengan metode modern</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            <span>Membekali santri dengan ilmu syar'i dan umum yang berimbang</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            <span>Mengembangkan kemampuan bahasa asing dan teknologi informasi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            <span>Membentuk akhlak dan kepribadian Islami yang paripurna</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Announcement Section -->
    <section class="py-16 bg-[#f0f4f8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Pengumuman</h2>
            <div class="w-20 h-1 bg-green-500 mx-auto rounded mb-8"></div>
            
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-4">
                @forelse($pengumumans as $pengumuman)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition duration-300 p-5 flex items-start gap-4 text-left border-l-4 
                    {{ $pengumuman->kategori === 'penting' ? 'border-red-500' : '' }}
                    {{ $pengumuman->kategori === 'akademik' ? 'border-blue-500' : '' }}
                    {{ $pengumuman->kategori === 'kegiatan' ? 'border-green-500' : '' }}
                    {{ $pengumuman->kategori === 'umum' ? 'border-gray-400' : '' }}">
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl flex items-center justify-center shadow-sm
                        {{ $pengumuman->kategori === 'penting' ? 'bg-gradient-to-br from-red-500 to-red-600 text-white' : '' }}
                        {{ $pengumuman->kategori === 'akademik' ? 'bg-gradient-to-br from-blue-500 to-blue-600 text-white' : '' }}
                        {{ $pengumuman->kategori === 'kegiatan' ? 'bg-gradient-to-br from-green-500 to-green-600 text-white' : '' }}
                        {{ $pengumuman->kategori === 'umum' ? 'bg-gradient-to-br from-gray-500 to-gray-600 text-white' : '' }}">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $pengumuman->judul }}</h3>
                            @if($pengumuman->status === 'aktif')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>
                                    Aktif
                                </span>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ Str::limit($pengumuman->isi, 150) }}</p>
                        <div class="flex items-center gap-4 mt-3 text-xs">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full font-medium
                                {{ $pengumuman->kategori === 'penting' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $pengumuman->kategori === 'akademik' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $pengumuman->kategori === 'kegiatan' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $pengumuman->kategori === 'umum' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ App\Models\Pengumuman::KATEGORI[$pengumuman->kategori] }}
                            </span>
                            <span class="text-gray-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $pengumuman->tanggal_mulai->format('d M Y') }}
                                @if($pengumuman->tanggal_selesai)
                                    - {{ $pengumuman->tanggal_selesai->format('d M Y') }}
                                @endif
                            </span>
                            @if($pengumuman->lampiran)
                                <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="text-green-600 hover:text-green-700 font-medium flex items-center gap-1 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    Lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <p class="text-gray-500 text-lg">Tidak ada pengumuman saat ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Berita Terkini Section -->
    <section id="berita" class="py-20 bg-[#f0f4f8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Berita Terkini</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto rounded"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @forelse($beritas as $berita)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . ((is_array($berita->gambar) && count($berita->gambar) > 0 ? $berita->gambar[0] : (is_string($berita->gambar) && $berita->gambar ? $berita->gambar : '')))) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400'">
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded mb-2">{{ $berita->tanggal->format('d M Y') }}</span>
                            <h3 class="font-bold text-gray-900 text-xl line-clamp-2 leading-tight">{{ $berita->judul }}</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4 flex-1">{{ Str::limit(strip_tags($berita->deskripsi), 120) }}</p>
                        <a href="{{ route('berita.detail', $berita->judul) }}" class="text-green-600 text-sm font-medium hover:underline inline-flex items-center gap-1">
                            Baca Selengkapnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
                @empty
                <!-- Fallback if no data -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition group flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400" alt="Berita 1" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded mb-2">Pendidikan</span>
                            <h3 class="font-bold text-gray-900 text-xl line-clamp-2 leading-tight">Pembukaan Tahun Ajaran Baru 2024/2025</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-4 flex-1">Pondok Pesantren Madinah El-Quds membuka pendaftaran santri baru untuk tahun ajaran yang akan datang.</p>
                        <a href="#" class="text-green-600 text-sm font-medium hover:underline inline-flex items-center gap-1">
                            Baca Selengkapnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('berita.public.index') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-md transition font-medium">Lihat Semua Berita</a>
            </div>
        </div>
    </section>
    
<!-- Prestasi Section -->
<section id="prestasi" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Prestasi Kami</h2>
            <div class="w-20 h-1 bg-green-500 mx-auto rounded"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($prestasis as $prestasi)
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer"
                 onclick="openPrestasiLightbox(this)"
                 data-images="{{ implode(',', array_map(function($f) { return asset('storage/' . $f); },  (is_array($prestasi->gambar) ? $prestasi->gambar : (is_string($prestasi->gambar) && $prestasi->gambar ? [$prestasi->gambar] : [])))) }}"
                 data-judul="{{ $prestasi->judul_prestasi }}"
                 data-deskripsi="{{ $prestasi->deskripsi }}"
                 data-tanggal="{{ $prestasi->tanggal ? $prestasi->tanggal->format('d M Y') : '' }}"
                 data-kategori="{{ $prestasi->kategori }}">
                <img 
                    src="{{ asset('storage/' . ((is_array($prestasi->gambar) && count($prestasi->gambar) > 0 ? $prestasi->gambar[0] : (is_string($prestasi->gambar) && $prestasi->gambar ? $prestasi->gambar : '')))) }}" 
                    alt="{{ $prestasi->judul_prestasi }}" 
                    class="w-full h-48 object-cover"
                    onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400'"
                >
                <div class="p-5">
                    <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-700 rounded-full">
                        {{ $prestasi->kategori }}
                    </span>
                    <h3 class="font-bold text-gray-900 mt-3 mb-2">{{ $prestasi->judul_prestasi }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($prestasi->deskripsi, 100) }}</p>
                    @if($prestasi->tanggal)
                    <span class="text-xs text-gray-400">
                        {{ $prestasi->tanggal->format('d M Y') }}
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8">
                <p class="text-gray-500">Belum ada prestasi yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Lihat Selengkapnya Button -->
        <div class="text-center mt-10">
            <a href="{{ route('prestasi.public.index') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-md transition font-medium">Lihat Semua Prestasi</a>
        </div>
    </div>
</section>
    <!-- Fasilitas Pesantren Section -->
    <section id="fasilitas" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Fasilitas Pesantren</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto rounded"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                @forelse($fasilitas->take(3) as $item)
                <div class="text-center group block cursor-pointer"
                     onclick="openFasilitasLightbox(this)"
                     data-images="{{ implode(',', array_map(function($f) { return asset('storage/' . $f); },  (is_array($item->gambar) ? $item->gambar : (is_string($item->gambar) && $item->gambar ? [$item->gambar] : [])))) }}"
                     data-judul="{{ $item->nama }}"
                     data-deskripsi="{{ $item->deskripsi }}"
                     data-kapasitas="{{ $item->jumlah_kapasitas }}"
                     data-kategori="{{ $item->kategori }}">
                    <div class="rounded-xl overflow-hidden shadow-lg mb-4 group-hover:shadow-xl transition">
                        <img src="{{ asset('storage/' . ((is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : (is_string($item->gambar) && $item->gambar ? $item->gambar : '')))) }}" alt="{{ $item->nama }}" class="w-full h-56 object-cover group-hover:scale-105 transition duration-300" onerror="this.src='https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=400'">
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg group-hover:text-green-600 transition">{{ $item->nama }}</h4>
                    <p class="text-gray-600 text-sm mt-2">{{ Str::limit(strip_tags($item->deskripsi), 80) }}</p>
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">{{ $item->kategori }}</span>
                </div>
                @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">Belum ada fasilitas yang ditampilkan.</p>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('fasilitas.public.index') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-md transition">Lihat Semua Fasilitas</a>
            </div>
        </div>
    </section>

    <!-- Penerimaan Santri Baru Banner -->
    <section class="py-12 bg-[#f0f4f8] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="relative max-w-4xl">
                <!-- Banner Background -->
                <div class="absolute inset-y-0 right-0 rounded-r-[100px] z-0" style="width: calc(50vw + 100%); background: linear-gradient(to bottom, #1e3a5f, #cbd5e1);"></div>
                
                <!-- Foto Siswa (Absolute pos di kanan bawah) -->
                <style>
                    .banner-image-container { display: none; }
                    @media (min-width: 768px) { .banner-image-container { display: block; } }
                </style>
                <div style="position: absolute; top: -10px; bottom: 0; right: 70px; width: 360px; z-index: 20;" class="banner-image-container">
                    <img src="{{ asset('images/students.png') }}?v={{ time() }}" alt="Siswa Baru" style="width: 100%; height: 100%; object-fit: contain; object-position: right bottom; filter: drop-shadow(-5px 5px 10px rgba(0, 0, 0, 0.15));">
                </div>

                <!-- Banner Content -->
                <div class="relative z-10 py-12 px-8 md:px-16 text-white max-w-lg">
                    <p class="text-sm mb-2">Ayo bersekolah di Madinah El-Quds !</p>
                    <h2 class="text-2xl md:text-3xl font-bold mb-1">Penerimaan Siswa Baru</h2>
                    <h3 class="text-xl md:text-2xl font-bold mb-3">Telah Dibuka</h3>
                    <p class="text-gray-200 text-sm mb-6">Penerimaan Siswa Baru telah dibuka untuk periode Tahun 2026/2027</p>
                    <button class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-full transition text-sm font-medium relative z-20">Mari Bergabung</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Kegiatan Ekstrakurikuler Section -->
    <section class="py-20 bg-[#f0f4f8]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Kegiatan Ekstrakurikuler</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto rounded"></div>
            </div>
            <div class="grid md:grid-cols-4 gap-6">
                @forelse($kegiatans->take(4) as $kegiatan)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition block cursor-pointer"
                     onclick="openEkstraLightbox(this)"
                     data-images="{{ implode(',', array_map(function($f) { return asset('storage/' . $f); },  (is_array($kegiatan->foto) ? $kegiatan->foto : (is_string($kegiatan->foto) && $kegiatan->foto ? [$kegiatan->foto] : [])))) }}"
                     data-judul="{{ $kegiatan->judul }}"
                     data-deskripsi="{{ $kegiatan->deskripsi }}"
                     data-tanggal="{{ $kegiatan->tanggal->format('d M Y') }}"
                     data-tempat="{{ $kegiatan->tempat }}">
                    <img src="{{ asset('storage/' . ((is_array($kegiatan->foto) && count($kegiatan->foto) > 0 ? $kegiatan->foto[0] : (is_string($kegiatan->foto) && $kegiatan->foto ? $kegiatan->foto : '')))) }}" alt="{{ $kegiatan->judul }}" class="w-full h-40 object-cover" onerror="this.src='https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=300'">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">{{ $kegiatan->judul }}</h3>
                        <p class="text-gray-600 text-xs mt-1">{{ Str::limit(strip_tags($kegiatan->deskripsi), 60) }}</p>
                    </div>
                </div>
                @empty
                <!-- Fallback if no data -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=300" alt="Pramuka" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Pramuka</h3>
                        <p class="text-gray-600 text-xs mt-1">Pembentukan karakter melalui kegiatan kepramukaan</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=300" alt="PMR" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">PMR</h3>
                        <p class="text-gray-600 text-xs mt-1">Palang Merah Remaja untuk keterampilan pertolongan pertama</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1516280440614-6697288d5d38?w=300" alt="Marawis" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Marawis</h3>
                        <p class="text-gray-600 text-xs mt-1">Grup hadrah dan marawis untuk mengembangkan bakat seni</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=300" alt="Olahraga" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Olahraga</h3>
                        <p class="text-gray-600 text-xs mt-1">Berbagai cabang olahraga untuk kebugaran fisik</p>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-10">
                <a href="{{ route('ekstrakurikuler.index') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-md transition">Lihat Semua Kegiatan</a>
            </div>
        </div>
    </section>

    <!-- Galeri Section -->
    <section id="galeri" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#1e3a5f] mb-2">Galeri dan Dokumentasi</h2>
                <div class="w-20 h-1 bg-green-500 mx-auto rounded"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($galeris as $galeri)
                <div class="relative group overflow-hidden rounded-xl aspect-square cursor-pointer"
                     onclick="openGaleriLightbox(this)"
                     data-images="{{ implode(',', array_map(function($f) { return asset('storage/' . $f); },  (is_array($galeri->gambar) ? $galeri->gambar : (is_string($galeri->gambar) && $galeri->gambar ? [$galeri->gambar] : [])))) }}"
                     data-judul="{{ $galeri->judul }}"
                     data-deskripsi="{{ $galeri->deskripsi }}">
                    <img src="{{ asset('storage/' . ((is_array($galeri->gambar) && count($galeri->gambar) > 0 ? $galeri->gambar[0] : (is_string($galeri->gambar) && $galeri->gambar ? $galeri->gambar : '')))) }}" alt="{{ $galeri->judul }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=300'">
                    <div class="gallery-overlay absolute inset-0 opacity-70 hover:opacity-100 transition duration-300 flex items-end p-4">
                        <div>
                            <span class="text-white text-sm font-medium block">{{ $galeri->judul }}</span>
                            <p class="text-white text-xs mt-1 line-clamp-2">{{ $galeri->deskripsi }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Fallback if no data -->
                @for($i = 0; $i < 8; $i++)
                <div class="relative group overflow-hidden rounded-xl aspect-square">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=300" alt="Gallery {{ $i+1 }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="gallery-overlay absolute inset-0 opacity-70 hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white text-sm font-medium">Kegiatan Santri</span>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>
        </div>
    </section>

    <!-- Lightbox Modals -->
    
    <!-- Prestasi Lightbox -->
    <div id="prestasi-lightbox" class="lightbox-overlay" onclick="closeLightbox(event, 'prestasi')">
        <div class="lightbox-content relative">
            <button class="lightbox-close" onclick="closeLightbox(event, 'prestasi', true)">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="relative bg-white rounded-xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="relative w-full h-64 sm:h-80 group bg-gray-100">
                <div id="p-lightbox-img-container" class="flex overflow-x-auto snap-x snap-mandatory w-full h-full scroll-smooth" style="scrollbar-width: none;"></div>
                <button type="button" onclick="document.getElementById('p-lightbox-img-container').scrollBy({left: -document.getElementById('p-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-left">&#10094;</button>
                <button type="button" onclick="document.getElementById('p-lightbox-img-container').scrollBy({left: document.getElementById('p-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-right">&#10095;</button>
            </div>
                <div class="p-6 overflow-y-auto flex-1 min-h-0">
                    <div class="flex justify-between items-start mb-2">
                        <h3 id="p-lightbox-judul" class="text-2xl font-bold text-gray-900"></h3>
                        <span id="p-lightbox-kategori" class="text-xs font-medium bg-green-100 text-green-700 px-3 py-1 rounded-full whitespace-nowrap ml-4"></span>
                    </div>
                    <p id="p-lightbox-tanggal" class="text-sm font-medium text-gray-500 mb-4 flex items-center gap-1"></p>
                    <div id="p-lightbox-deskripsi" class="text-gray-700 text-base leading-relaxed whitespace-pre-wrap"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fasilitas Lightbox -->
    <div id="fasilitas-lightbox" class="lightbox-overlay" onclick="closeLightbox(event, 'fasilitas')">
        <div class="lightbox-content relative">
            <button class="lightbox-close" onclick="closeLightbox(event, 'fasilitas', true)">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="relative bg-white rounded-xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="relative w-full h-64 sm:h-80 group bg-gray-100">
                <div id="f-lightbox-img-container" class="flex overflow-x-auto snap-x snap-mandatory w-full h-full scroll-smooth" style="scrollbar-width: none;"></div>
                <button type="button" onclick="document.getElementById('f-lightbox-img-container').scrollBy({left: -document.getElementById('f-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-left">&#10094;</button>
                <button type="button" onclick="document.getElementById('f-lightbox-img-container').scrollBy({left: document.getElementById('f-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-right">&#10095;</button>
            </div>
                <div class="p-6 overflow-y-auto flex-1 min-h-0">
                    <div class="flex justify-between items-start mb-2">
                        <h3 id="f-lightbox-judul" class="text-2xl font-bold text-gray-900"></h3>
                        <span id="f-lightbox-kategori" class="text-xs font-medium bg-green-100 text-green-700 px-3 py-1 rounded-full whitespace-nowrap ml-4"></span>
                    </div>
                    <p id="f-lightbox-kapasitas" class="text-sm font-medium text-gray-500 mb-4"></p>
                    <div id="f-lightbox-deskripsi" class="text-gray-700 text-base leading-relaxed whitespace-pre-wrap"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ekstrakurikuler Lightbox -->
    <div id="ekstra-lightbox" class="lightbox-overlay" onclick="closeLightbox(event, 'ekstra')">
        <div class="lightbox-content relative">
            <button class="lightbox-close" onclick="closeLightbox(event, 'ekstra', true)">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="relative bg-white rounded-xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="relative w-full h-64 sm:h-80 group bg-gray-100">
                <div id="e-lightbox-img-container" class="flex overflow-x-auto snap-x snap-mandatory w-full h-full scroll-smooth" style="scrollbar-width: none;"></div>
                <button type="button" onclick="document.getElementById('e-lightbox-img-container').scrollBy({left: -document.getElementById('e-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-left">&#10094;</button>
                <button type="button" onclick="document.getElementById('e-lightbox-img-container').scrollBy({left: document.getElementById('e-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-right">&#10095;</button>
            </div>
                <div class="p-6 overflow-y-auto flex-1 min-h-0">
                    <div class="flex justify-between items-start mb-2">
                        <h3 id="e-lightbox-judul" class="text-2xl font-bold text-gray-900"></h3>
                        <span id="e-lightbox-tanggal" class="text-xs font-medium bg-green-100 text-green-700 px-3 py-1 rounded-full whitespace-nowrap ml-4"></span>
                    </div>
                    <p id="e-lightbox-tempat" class="text-sm font-medium text-gray-500 mb-4 flex items-center gap-1"></p>
                    <div id="e-lightbox-deskripsi" class="text-gray-700 text-base leading-relaxed whitespace-pre-wrap"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Galeri Lightbox -->
    <div id="galeri-lightbox" class="lightbox-overlay" onclick="closeLightbox(event, 'galeri')">
        <div class="lightbox-content relative">
            <button class="lightbox-close" onclick="closeLightbox(event, 'galeri', true)">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="relative bg-[#1e3a5f] rounded-xl overflow-hidden flex flex-col max-h-[90vh] shadow-2xl">
                <div class="w-full bg-gray-900 flex items-center justify-center h-[45vh] sm:h-[55vh]">
                    <div class="relative w-full h-[45vh] sm:h-[55vh] group bg-gray-100">
                <div id="g-lightbox-img-container" class="flex overflow-x-auto snap-x snap-mandatory w-full h-full scroll-smooth" style="scrollbar-width: none;"></div>
                <button type="button" onclick="document.getElementById('g-lightbox-img-container').scrollBy({left: -document.getElementById('g-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-left">&#10094;</button>
                <button type="button" onclick="document.getElementById('g-lightbox-img-container').scrollBy({left: document.getElementById('g-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-right">&#10095;</button>
            </div>
                </div>
                <div class="p-6 overflow-y-auto flex-1 min-h-0">
                    <h3 id="g-lightbox-judul" class="text-xl font-bold text-white mb-2"></h3>
                    <p id="g-lightbox-deskripsi" class="text-gray-200 text-sm leading-relaxed whitespace-pre-wrap"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function openPrestasiLightbox(element) {
        const pContainer = document.getElementById('p-lightbox-img-container');
    if (pContainer) {
        pContainer.innerHTML = '';
                let imagesAttr = element.getAttribute('data-images');
        let images = imagesAttr ? imagesAttr.split(',').filter(i => i.trim() !== '') : [];
        if (images.length === 0) {
            images.push('https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600');
        }
        images.forEach(imgUrl => {
            let wrapper = document.createElement('div');
            wrapper.className = 'w-full h-full flex-shrink-0 snap-center';
            wrapper.style.minWidth = '100%';
            
            let img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            // Exception for Galeri which uses object-contain
            if (element.getAttribute('onclick') && element.getAttribute('onclick').includes('Galeri')) {
                img.className = 'w-full h-full object-contain';
            }
            img.src = imgUrl;
            img.onerror = function() {
                this.onerror = null;
                this.src = 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600';
            };
            
            wrapper.appendChild(img);
              // Cleanly append to whatever container is active
              try { if (typeof pContainer !== 'undefined' && pContainer) pContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof fContainer !== 'undefined' && fContainer) fContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof eContainer !== 'undefined' && eContainer) eContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof gContainer !== 'undefined' && gContainer) gContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof bContainer !== 'undefined' && bContainer) bContainer.appendChild(wrapper); } catch(e){}
        });
    }
    document.getElementById('p-lightbox-judul').textContent = element.getAttribute('data-judul');
    document.getElementById('p-lightbox-deskripsi').innerHTML = element.getAttribute('data-deskripsi');
    document.getElementById('p-lightbox-kategori').textContent = element.getAttribute('data-kategori');
    
    const tanggal = element.getAttribute('data-tanggal');
    const tanggalEl = document.getElementById('p-lightbox-tanggal');
    if (tanggal) {
        tanggalEl.textContent = tanggal;
        tanggalEl.style.display = 'flex';
    } else {
        tanggalEl.style.display = 'none';
    }
    
    document.getElementById('prestasi-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function openFasilitasLightbox(element) {
        const fContainer = document.getElementById('f-lightbox-img-container');
    if (fContainer) {
        fContainer.innerHTML = '';
                let imagesAttr = element.getAttribute('data-images');
        let images = imagesAttr ? imagesAttr.split(',').filter(i => i.trim() !== '') : [];
        if (images.length === 0) {
            images.push('https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600');
        }
        images.forEach(imgUrl => {
            let wrapper = document.createElement('div');
            wrapper.className = 'w-full h-full flex-shrink-0 snap-center';
            wrapper.style.minWidth = '100%';
            
            let img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            // Exception for Galeri which uses object-contain
            if (element.getAttribute('onclick') && element.getAttribute('onclick').includes('Galeri')) {
                img.className = 'w-full h-full object-contain';
            }
            img.src = imgUrl;
            img.onerror = function() {
                this.onerror = null;
                this.src = 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600';
            };
            
            wrapper.appendChild(img);
              // Cleanly append to whatever container is active
              try { if (typeof pContainer !== 'undefined' && pContainer) pContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof fContainer !== 'undefined' && fContainer) fContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof eContainer !== 'undefined' && eContainer) eContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof gContainer !== 'undefined' && gContainer) gContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof bContainer !== 'undefined' && bContainer) bContainer.appendChild(wrapper); } catch(e){}
        });
    }
    document.getElementById('f-lightbox-judul').textContent = element.getAttribute('data-judul');
    document.getElementById('f-lightbox-deskripsi').innerHTML = element.getAttribute('data-deskripsi');
    document.getElementById('f-lightbox-kategori').textContent = element.getAttribute('data-kategori');
    
    const kapasitas = element.getAttribute('data-kapasitas');
    const kapasitasEl = document.getElementById('f-lightbox-kapasitas');
    if (kapasitas) {
        kapasitasEl.textContent = 'Kapasitas: ' + kapasitas;
        kapasitasEl.style.display = 'block';
    } else {
        kapasitasEl.style.display = 'none';
    }
    
    document.getElementById('fasilitas-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function openEkstraLightbox(element) {
        const eContainer = document.getElementById('e-lightbox-img-container');
    if (eContainer) {
        eContainer.innerHTML = '';
                let imagesAttr = element.getAttribute('data-images');
        let images = imagesAttr ? imagesAttr.split(',').filter(i => i.trim() !== '') : [];
        if (images.length === 0) {
            images.push('https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600');
        }
        images.forEach(imgUrl => {
            let wrapper = document.createElement('div');
            wrapper.className = 'w-full h-full flex-shrink-0 snap-center';
            wrapper.style.minWidth = '100%';
            
            let img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            // Exception for Galeri which uses object-contain
            if (element.getAttribute('onclick') && element.getAttribute('onclick').includes('Galeri')) {
                img.className = 'w-full h-full object-contain';
            }
            img.src = imgUrl;
            img.onerror = function() {
                this.onerror = null;
                this.src = 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600';
            };
            
            wrapper.appendChild(img);
              // Cleanly append to whatever container is active
              try { if (typeof pContainer !== 'undefined' && pContainer) pContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof fContainer !== 'undefined' && fContainer) fContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof eContainer !== 'undefined' && eContainer) eContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof gContainer !== 'undefined' && gContainer) gContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof bContainer !== 'undefined' && bContainer) bContainer.appendChild(wrapper); } catch(e){}
        });
    }
    document.getElementById('e-lightbox-judul').textContent = element.getAttribute('data-judul');
    document.getElementById('e-lightbox-deskripsi').innerHTML = element.getAttribute('data-deskripsi');
    document.getElementById('e-lightbox-tanggal').textContent = element.getAttribute('data-tanggal');
    
    const tempat = element.getAttribute('data-tempat');
    const tempatEl = document.getElementById('e-lightbox-tempat');
    if (tempat) {
        tempatEl.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> ${tempat}`;
        tempatEl.style.display = 'flex';
    } else {
        tempatEl.style.display = 'none';
    }
    
    document.getElementById('ekstra-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function openGaleriLightbox(element) {
        const gContainer = document.getElementById('g-lightbox-img-container');
    if (gContainer) {
        gContainer.innerHTML = '';
                let imagesAttr = element.getAttribute('data-images');
        let images = imagesAttr ? imagesAttr.split(',').filter(i => i.trim() !== '') : [];
        if (images.length === 0) {
            images.push('https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600');
        }
        images.forEach(imgUrl => {
            let wrapper = document.createElement('div');
            wrapper.className = 'w-full h-full flex-shrink-0 snap-center';
            wrapper.style.minWidth = '100%';
            
            let img = document.createElement('img');
            img.className = 'w-full h-full object-cover';
            // Exception for Galeri which uses object-contain
            if (element.getAttribute('onclick') && element.getAttribute('onclick').includes('Galeri')) {
                img.className = 'w-full h-full object-contain';
            }
            img.src = imgUrl;
            img.onerror = function() {
                this.onerror = null;
                this.src = 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600';
            };
            
            wrapper.appendChild(img);
              // Cleanly append to whatever container is active
              try { if (typeof pContainer !== 'undefined' && pContainer) pContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof fContainer !== 'undefined' && fContainer) fContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof eContainer !== 'undefined' && eContainer) eContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof gContainer !== 'undefined' && gContainer) gContainer.appendChild(wrapper); } catch(e){}
              try { if (typeof bContainer !== 'undefined' && bContainer) bContainer.appendChild(wrapper); } catch(e){}
        });
    }
    document.getElementById('g-lightbox-judul').textContent = element.getAttribute('data-judul');
    document.getElementById('g-lightbox-deskripsi').textContent = element.getAttribute('data-deskripsi');
    
    document.getElementById('galeri-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox(event, type, forceClose = false) {
    const modalId = type === 'fasilitas' ? 'fasilitas-lightbox' : (type === 'ekstra' ? 'ekstra-lightbox' : (type === 'prestasi' ? 'prestasi-lightbox' : 'galeri-lightbox'));
    if (forceClose || event.target === document.getElementById(modalId)) {
        document.getElementById(modalId).classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.lightbox-overlay.active').forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
});
</script>
@endsection
