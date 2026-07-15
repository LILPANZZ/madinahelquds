@extends('layouts.public')

@section('title', 'Hasil Pencarian')

@section('styles')
    <style>
        .search-hero {
            background-image: linear-gradient(to bottom, rgba(30,58,95,0.3), rgba(30,58,95,0.7)), url('{{ asset('storage/bg/bg2.png') }}');
            background-size: cover;
            background-position: center;
        }

        /* Lightbox styles */
        .lightbox-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            z-index: 50;
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
        .lightbox-img {
            max-height: 65vh;
            width: 100%;
            object-fit: contain;
            border-radius: 12px 12px 0 0;
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
    <section class="search-hero h-80 md:h-[300px] flex items-center justify-center relative">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/80 to-transparent"></div>
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Hasil Pencarian</h1>
            <p class="text-lg text-gray-200">"{{ $query }}"</p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-12 bg-[#f0f4f8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="mb-8 max-w-2xl mx-auto flex gap-2">
                <input type="text" name="q" value="{{ $query }}" placeholder="Cari lagi..." class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium">Cari</button>
            </form>

            @php
                $totalResults = $beritas->count() + $kegiatans->count() + $fasilitas->count() + $galeris->count() + $prestasis->count();
            @endphp

            @if($totalResults === 0)
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <p class="text-lg">Tidak ada hasil ditemukan untuk "{{ $query }}"</p>
                    <p class="text-sm mt-2">Coba kata kunci lain</p>
                </div>
            @else
                <p class="text-gray-600 mb-6">Ditemukan {{ $totalResults }} hasil</p>

                <!-- Berita Results -->
                @if($beritas->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                        <span class="bg-green-600 text-white text-xs px-2 py-1 rounded">{{ $beritas->count() }}</span>
                        Berita
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($beritas as $item)
                        <a href="{{ route('berita.detail', $item->judul) }}" class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition block">
                            <img src="{{ '/storage/' . ((is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : (is_string($item->gambar) && $item->gambar ? $item->gambar : ''))) }}" alt="{{ $item->judul }}" class="w-full h-40 object-cover" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400'">
                            <div class="p-4">
                                <span class="text-xs text-green-600 font-medium">{{ $item->tanggal->format('d M Y') }}</span>
                                <h3 class="font-bold text-gray-900 mt-1">{{ $item->judul }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ Str::limit(strip_tags($item->deskripsi), 80) }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Kegiatan Results -->
                @if($kegiatans->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded">{{ $kegiatans->count() }}</span>
                        Kegiatan
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($kegiatans as $item)
                        <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition cursor-pointer"
                             onclick="openEkstraLightbox(this)"
                             data-images="{{ implode(',', array_map(function($f) { return '/storage/' . $f; },  (is_array($item->foto) ? $item->foto : (is_string($item->foto) && $item->foto ? [$item->foto] : [])))) }}"
                             data-judul="{{ $item->judul }}"
                             data-deskripsi="{{ $item->deskripsi }}"
                             data-tanggal="{{ $item->tanggal ? $item->tanggal->format('d M Y') : '' }}"
                             data-tempat="{{ $item->tempat }}">
                            <img src="{{ '/storage/' . ((is_array($item->foto) && count($item->foto) > 0 ? $item->foto[0] : (is_string($item->foto) && $item->foto ? $item->foto : ''))) }}" alt="{{ $item->judul }}" class="w-full h-40 object-cover" onerror="this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400'">
                            <div class="p-4">
                                <span class="text-xs text-blue-600 font-medium">{{ $item->tanggal->format('d M Y') }}</span>
                                <h3 class="font-bold text-gray-900 mt-1">{{ $item->judul }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ Str::limit(strip_tags($item->deskripsi), 80) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Fasilitas Results -->
                @if($fasilitas->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                        <span class="bg-purple-600 text-white text-xs px-2 py-1 rounded">{{ $fasilitas->count() }}</span>
                        Fasilitas
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($fasilitas as $item)
                        <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition cursor-pointer"
                             onclick="openFasilitasLightbox(this)"
                             data-images="{{ implode(',', array_map(function($f) { return '/storage/' . $f; },  (is_array($item->gambar) ? $item->gambar : (is_string($item->gambar) && $item->gambar ? [$item->gambar] : [])))) }}"
                             data-judul="{{ $item->nama }}"
                             data-deskripsi="{{ $item->deskripsi }}"
                             data-kapasitas="{{ $item->jumlah_kapasitas }}"
                             data-kategori="{{ $item->kategori }}">
                            <img src="{{ '/storage/' . ((is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : (is_string($item->gambar) && $item->gambar ? $item->gambar : ''))) }}" alt="{{ $item->nama }}" class="w-full h-40 object-cover" onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?w=400'">
                            <div class="p-4">
                                <span class="text-xs text-purple-600 font-medium bg-purple-50 px-2 py-1 rounded">{{ $item->kategori }}</span>
                                <h3 class="font-bold text-gray-900 mt-2">{{ $item->nama }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ Str::limit(strip_tags($item->deskripsi), 80) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Galeri Results -->
                @if($galeris->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                        <span class="bg-orange-600 text-white text-xs px-2 py-1 rounded">{{ $galeris->count() }}</span>
                        Galeri
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($galeris as $item)
                        <div class="relative group overflow-hidden rounded-xl aspect-square cursor-pointer"
                             onclick="openGaleriLightbox(this)"
                             data-images="{{ implode(',', array_map(function($f) { return '/storage/' . $f; },  (is_array($item->gambar) ? $item->gambar : (is_string($item->gambar) && $item->gambar ? [$item->gambar] : [])))) }}"
                             data-judul="{{ $item->judul }}"
                             data-deskripsi="{{ $item->deskripsi }}">
                            <img src="{{ '/storage/' . ((is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : (is_string($item->gambar) && $item->gambar ? $item->gambar : ''))) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=300'">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/80 to-transparent opacity-70 hover:opacity-100 transition duration-300 flex items-end p-3">
                                <div>
                                    <span class="text-xs text-orange-400 font-medium">{{ $item->kategori }}</span>
                                    <h3 class="text-white font-medium text-sm">{{ $item->judul }}</h3>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Prestasi Results -->
                @if($prestasis->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                        <span class="bg-yellow-600 text-white text-xs px-2 py-1 rounded">{{ $prestasis->count() }}</span>
                        Prestasi
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($prestasis as $item)
                        <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition cursor-pointer"
                             onclick="openPrestasiLightbox(this)"
                             data-images="{{ implode(',', array_map(function($f) { return '/storage/' . $f; },  (is_array($item->gambar) ? $item->gambar : (is_string($item->gambar) && $item->gambar ? [$item->gambar] : [])))) }}"
                             data-judul="{{ $item->judul_prestasi }}"
                             data-deskripsi="{{ $item->deskripsi }}"
                             data-tanggal="{{ $item->tanggal ? $item->tanggal->format('d M Y') : '' }}"
                             data-kategori="{{ $item->kategori }}">
                            <img src="{{ '/storage/' . ((is_array($item->gambar) && count($item->gambar) > 0 ? $item->gambar[0] : (is_string($item->gambar) && $item->gambar ? $item->gambar : ''))) }}" alt="{{ $item->judul_prestasi }}" class="w-full h-40 object-cover" onerror="this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400'">
                            <div class="p-4">
                                <span class="text-xs text-yellow-600 font-medium bg-yellow-50 px-2 py-1 rounded">{{ $item->kategori }}</span>
                                <h3 class="font-bold text-gray-900 mt-2">{{ $item->judul_prestasi }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ Str::limit(strip_tags($item->deskripsi), 80) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endif
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
                <div class="p-6 overflow-y-auto flex-1">
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
                <div class="p-6 overflow-y-auto flex-1">
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
                <div class="p-6 overflow-y-auto flex-1">
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
            <div class="relative bg-[#1e3a5f] rounded-xl overflow-hidden flex flex-col shadow-2xl">
                <div class="w-full bg-gray-900 flex items-center justify-center h-[45vh] sm:h-[55vh]">
                    <div class="relative w-full h-[45vh] sm:h-[55vh] group bg-gray-100">
                <div id="g-lightbox-img-container" class="flex overflow-x-auto snap-x snap-mandatory w-full h-full scroll-smooth" style="scrollbar-width: none;"></div>
                <button type="button" onclick="document.getElementById('g-lightbox-img-container').scrollBy({left: -document.getElementById('g-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-left">&#10094;</button>
                <button type="button" onclick="document.getElementById('g-lightbox-img-container').scrollBy({left: document.getElementById('g-lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-right">&#10095;</button>
            </div>
                </div>
                <div class="p-6 max-h-[35vh] overflow-y-auto">
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
