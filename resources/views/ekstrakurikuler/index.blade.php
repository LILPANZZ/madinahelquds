@extends('layouts.public')

@section('title', 'Kegiatan Ekstrakurikuler')

@section('styles')
    <style>
        .ekstrakurikuler-hero {
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
    <section class="ekstrakurikuler-hero h-80 md:h-[400px] flex items-end relative">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1e3a5f]/80 to-transparent"></div>
    </section>

    <!-- Content Section -->
    <section class="py-12 bg-[#f0f4f8]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold text-[#1e3a5f] mb-8">Kegiatan Ekstrakurikuler</h1>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($kegiatans as $kegiatan)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition cursor-pointer"
                     onclick="openLightbox(this)"
                     data-images="{{ implode(',', array_map(function($f) { return '/storage/' . $f; },  (is_array($kegiatan->foto) ? $kegiatan->foto : (is_string($kegiatan->foto) && $kegiatan->foto ? [$kegiatan->foto] : [])))) }}"
                     data-judul="{{ $kegiatan->judul }}"
                     data-deskripsi="{{ $kegiatan->deskripsi }}"
                     data-tanggal="{{ $kegiatan->tanggal->format('d M Y') }}"
                     data-tempat="{{ $kegiatan->tempat }}">
                    <img src="{{ '/storage/' . ((is_array($kegiatan->foto) && count($kegiatan->foto) > 0 ? $kegiatan->foto[0] : (is_string($kegiatan->foto) && $kegiatan->foto ? $kegiatan->foto : ''))) }}" alt="{{ $kegiatan->judul }}" class="w-full h-48 object-cover" onerror="this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400'">
                    <div class="p-5">
                        <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded">{{ $kegiatan->tanggal->format('d M Y') }}</span>
                        <h3 class="font-bold text-gray-900 mt-2 text-lg">{{ $kegiatan->judul }}</h3>
                        <p class="text-gray-600 text-sm mt-2">{{ Str::limit(strip_tags($kegiatan->deskripsi), 100) }}</p>
                        @if($kegiatan->tempat)
                        <p class="text-xs text-gray-500 mt-3 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $kegiatan->tempat }}
                        </p>
                        @endif
                    </div>
                </div>
                @empty
                <!-- Fallback if no data -->
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>Belum ada data kegiatan yang tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div id="ekstra-lightbox" class="lightbox-overlay" onclick="closeLightbox(event)">
        <div class="lightbox-content relative">
            <button class="lightbox-close" onclick="closeLightbox(event, true)">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="relative bg-white rounded-xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="relative w-full h-64 sm:h-80 group bg-gray-100">
            <div id="lightbox-img-container" class="flex overflow-x-auto snap-x snap-mandatory w-full h-full scroll-smooth" style="scrollbar-width: none;"></div>
            <button type="button" onclick="document.getElementById('lightbox-img-container').scrollBy({left: -document.getElementById('lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-left">&#10094;</button>
            <button type="button" onclick="document.getElementById('lightbox-img-container').scrollBy({left: document.getElementById('lightbox-img-container').clientWidth, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 text-white w-10 h-10 shadow-lg   flex items-center justify-center rounded-full opacity-70 hover:opacity-100 transition-opacity hover:bg-black/70 slider-btn slider-btn-right">&#10095;</button>
        </div>
                <div class="p-6 overflow-y-auto flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <h3 id="lightbox-judul" class="text-2xl font-bold text-gray-900"></h3>
                        <span id="lightbox-tanggal" class="text-xs font-medium bg-green-100 text-green-700 px-3 py-1 rounded-full whitespace-nowrap ml-4"></span>
                    </div>
                    <p id="lightbox-tempat" class="text-sm font-medium text-gray-500 mb-4 flex items-center gap-1"></p>
                    <div id="lightbox-deskripsi" class="text-gray-700 text-base leading-relaxed whitespace-pre-wrap"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function openLightbox(element) {
        const container = document.getElementById('lightbox-img-container');
    if (container) {
        container.innerHTML = '';
        let imagesAttr = element.getAttribute('data-images');
        let images = imagesAttr ? imagesAttr.split(',').filter(i => i.trim() !== '') : [];
        if (images.length === 0) {
            images.push('https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600');
        }
        images.forEach(imgUrl => {
            let fullImg = imgUrl.startsWith('http') || imgUrl.startsWith('/storage') ? imgUrl : '/storage/' + imgUrl;
            let objectClass = element.getAttribute('onclick') && element.getAttribute('onclick').includes('Galeri') ? 'object-contain' : 'object-cover';
            container.innerHTML += '<div class="w-full h-full flex-shrink-0 snap-center" style="min-width: 100%;"><img src="' + fullImg + '" class="w-full h-full ' + objectClass + '" onerror="this.src=\'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600\'"></div>';
        });
    }
    document.getElementById('lightbox-judul').textContent = element.getAttribute('data-judul');
    document.getElementById('lightbox-deskripsi').innerHTML = element.getAttribute('data-deskripsi');
    
    document.getElementById('lightbox-tanggal').textContent = element.getAttribute('data-tanggal');
    
    const tempat = element.getAttribute('data-tempat');
    const tempatEl = document.getElementById('lightbox-tempat');
    if (tempat) {
        tempatEl.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> ${tempat}`;
        tempatEl.style.display = 'flex';
    } else {
        tempatEl.style.display = 'none';
    }
    
    document.getElementById('ekstra-lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox(event, forceClose = false) {
    if (forceClose || event.target === document.getElementById('ekstra-lightbox')) {
        document.getElementById('ekstra-lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('ekstra-lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
});
</script>
@endsection
